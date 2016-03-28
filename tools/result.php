<?php
$time = microtime(true);
define("DS", "/");

$pathToCurrentTranslations = __DIR__ . DS . ".." . DS . 'app' . DS . 'locale' . DS . 'ru_RU' . DS;
$nonTranslatableFilePath = __DIR__ . DS . 'non_translatable_dictionary.csv';
$reportFilePath = __DIR__ . DS .'PROGRESS.md';


$files = getAllFilesFromDirectory($pathToCurrentTranslations);

$report = createReport($files, $nonTranslatableFilePath);

saveResult($report, $reportFilePath);
print "Done in " . round(microtime(true) - $time, 2) . "\n";
print "Translated: " . $report["translated"] . "\n";
print "Non Translated: " . $report["nontranslated"];
//print_r($report["nontranslatedArray"]);


// =========================================== functions =====================================================

/**
 * @param array $filesData
 * @param string $fullPath
 */
function saveResult($filesData, $resultFilename)
{
    $fp = fopen($resultFilename, "wb");
    $output = array();
    $output[] = "";
    $output[] = "# Готовность перевода";
    $output[] = "";
    $output[] = "| | | |";
    $output[] = "|-|-|-|";
    $output[] = "|**Общий прогресс**|" . getResultString($filesData["total"], $filesData["translated"]);
    $output[] = "";


    if (isset($filesData["theme"])) {
        $output[] = "## Темы";
        $output[] = "";
        $output[] = "| | | |";
        $output[] = "|-|-|-|";
        foreach ($filesData["theme"] as $code => $result) {
            $output[] = "|" . $code . "|" . getResultString($result["total"], $result["translated"]);
        }
        $output[] = "";
    }

    if (isset($filesData["module"])) {
        $output[] = "## Модули";
        $output[] = "";
        $output[] = "| | | |";
        $output[] = "|-|-|-|";
        foreach ($filesData["module"] as $code => $result) {
            $output[] = "|" . $code . "|" . getResultString($result["total"], $result["translated"]);
        }
        $output[] = "";
    }
    if (isset($filesData["lib"])) {
        $output[] = "## Библиотеки";
        $output[] = "";
        $output[] = "| | | |";
        $output[] = "|-|-|-|";
        foreach ($filesData["lib"] as $code => $result) {
            $output[] = "|" . $code . "|" . getResultString($result["total"], $result["translated"]);
        }
    }
    fwrite($fp, implode("\n", $output));
    fclose($fp);
}

/**
 * @param int $total
 * @param int $translated
 * @return string
 */
function getResultString($total, $translated)
{
    $percents = round(100 * $translated / max($total, 1));
    return $translated . "/" . $total . "|![Progress](http://progressed.io/bar/" . $percents . ")|";
}



/**
 * @param array $filesArray
 * @param string $nonTranslatableFilePath
 * @return array
 */
function createReport($filesArray, $nonTranslatableFilePath)
{
    $result = array(
        "total" => 0,
        "error" => 0,
        "translated" => 0,
        // for result or debug
        // count non translated word
        "nontranslated" => 0,
        // array of non translated csv row (word, word, module, module Name)
        "nontranslatedArray" => array()
    );

    $nonTranslatableDictionary = readCsv($nonTranslatableFilePath);
    $hashNonTranslatableDictionary =  createHasheNonTranslableDictinary($nonTranslatableDictionary);

    foreach($filesArray as $file){
        $moduleName = getModuleName($file['name']);
        $translationsCsvFile = readCsv($file['path']);

        $lineCsv = 1;
        foreach($translationsCsvFile as $row){
            // magento csv row contents 2 cells
            if (count($row) < 1) {
                $result["error"]++;
                continue;
            }

            // module
            if (!isset($result['module'])) {
                $result['module'] = array();
            }

            if (!isset($result['module'][$moduleName])) {
                $result['module'][$moduleName] = array("total" => 0, "translated" => 0);
            }

            $result['module'][$moduleName]["total"]++;
            $result["total"]++;

            if (strcmp($row[0], $row[1]) != 0) {
                $result['module'][$moduleName]["translated"]++;
                $result["translated"]++;
            } else {
                $wordMd5 = md5($row[0]);
                if (array_key_exists($wordMd5, $hashNonTranslatableDictionary)) {
                    $result['module'][$moduleName]["translated"]++;
                    $result["translated"]++;
                    $result["nontranslated"]++;
                    $result["nontranslatedArray"][$moduleName] = "text: ". $row[0].", line: ".$lineCsv;
                }
            }

            $lineCsv++;

        }// end foreach($translationsCsvFile)

    }// end foreach($filesArray)

    return $result;
}


/**
 * @param string $fileName
 * @return string
 */
function getModuleName($fileName)
{
    $position = mb_strpos($fileName, '.');
    if($position){
        $fileName = mb_substr($fileName, 0, $position);
    }
    return $fileName;
}


/**
 * for fast search conver csv to hash
 * return array format [ md5(csv[0]) (hash of translated word) ] = array csv row (one or more if is several modules)
 * if return array empty exit with error msg.
 *
 * @param array $csv
 * @return array
 */
function createHasheNonTranslableDictinary($csv)
{
    $cash = array();
    foreach ($csv as $row) {
        $hashFindWord = md5($row[0]);
        // if exists check is duplicate or other module
        if (array_key_exists($hashFindWord, $cash)) {
            $hashRow = md5(json_encode($row));
            $duplicate = false;
            foreach ($cash[$hashFindWord] as $rowAdded) {
                if (md5(json_encode($rowAdded)) == $hashRow) {
                    $duplicate = true;
                }
            }
            if (!$duplicate) {
                $cash[$hashFindWord][] = $row;
            }
        } else {
            $cash[$hashFindWord][] = $row;
        }
    }

    if (count($cash) == 0) {
        echo 'Pleas check not translated .csv file';
        exit();
    }
    return $cash;
}


/**
 * @param string $filePath
 * @return array (of rows from csv)
 */
function readCsv($filePath)
{
    $allCsv = array();

    if (!file_exists($filePath)) {
        echo 'No file: ' . $filePath;
        exit();
    }

    $fp = fopen($filePath, "rb");

    while (!feof($fp)) {
        $row = fgetcsv($fp, 8192);
        // remove empty row
        if (count($row) > 1) {
            if (count($row) == 4) {
                $subModules = explode(",", $row[3]);
                foreach ($subModules as $_subModule) {
                    $row[3] = $_subModule;
                    $allCsv[] = $row;
                }
            } else {
                $allCsv[] = $row;
            }
        }
    }

    fclose($fp);
    return $allCsv;
}


/**
 * return files array from directory
 * @param string $path
 * @return array format [] = array(path => fullPath, name => fileName)
 */
function getAllFilesFromDirectory($path)
{
    $filesArray = array();

    if (is_dir($path)) {

        if ($handle = opendir($path)) {

            while (false !== ($fileName = readdir($handle))) {
                if ($fileName != "." && $fileName != "..") {
                    if (is_file($path . DS . $fileName)) {
                        $filesArray[] = array(
                            'path' => $path . DS . $fileName,
                            'name' => $fileName
                        );
                    }
                }
            }
            closedir($handle);
        }
    } else {
        echo "patch not valid! \n";
        echo $path . "\n";
        exit();
    }

    return $filesArray;
}

