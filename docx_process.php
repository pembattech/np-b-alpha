<?php
include_once 'is_login.php';
checkLogin();

include_once 'navbar.php';
?>

<style>
    body {
        background-color: #f4f7fa;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        margin: 10px auto;
    }

    h2 {
        color: #007BFF;
        font-size: 28px;
        margin-bottom: 15px;
    }

    p {
        color: #555;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .download-button {
        display: inline-block;
        padding: 12px 30px;
        font-size: 16px;
        color: white;
        background-color: #007BFF;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .download-button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .download-button:active {
        background-color: #004085;
        transform: translateY(0);
    }

    .download-button:focus {
        outline: none;
    }

    .error-message {
        background-color: #ff4d4d;
        /* Bright red for error */
        color: #fff;
        /* White text for contrast */
        padding: 20px 30px;
        margin: 20px auto;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.5s ease-in-out;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Optional for smaller screens */
    @media (max-width: 768px) {
        .error-message {
            font-size: 16px;
            padding: 15px 20px;
        }
    }
</style>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'vendor/autoload.php';

use Nilambar\NepaliDate\NepaliDate;

try {

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get department value
        $department = $_POST['department'] ?? null;

        // Initialize variables for each field
        $dmliField = $chalaniNumber = $chalaniDate = $accountNumber = $citizenNumber = $name = $amount = $amountInWords = $revenueField1 = $revenueField2 = null;

        // Process form fields based on the selected department
        switch ($department) {
            case 'DMLI':
                // Get DMLI field
                $chalaniNumber = $_POST['dmli_chalaniNumber'] ?? null;
                $chalaniDate = $_POST['dmli_chalaniDate'] ?? null;
                break;

            case 'SupremeCourt':
                // Get Supreme Court fields
                $chalaniNumber = $_POST['supreme_chalaniNumber'] ?? null;
                $chalaniDate = $_POST['supreme_chalaniDate'] ?? null;
                $accountNumber = $_POST['supreme_accountNumber'] ?? null;
                $amount = $_POST['supreme_amount'] ?? null;
                $amountInWords = $_POST['supreme_amountInWords'] ?? null;
                break;

            case 'InvalidAccount':
                // Get Invalid Account fields
                $chalaniNumber = $_POST['invalid_chalaniNumber'] ?? null;
                $chalaniDate = $_POST['invalid_chalaniDate'] ?? null;
                $accountNumber = $_POST['invalid_accountNumber'] ?? null;
                break;

            case 'NepalPoliceHeadOffice':
                // Get Nepal Police Head Office fields
                $chalaniNumber = $_POST['np_chalaniNumber'] ?? null;
                $chalaniDate = $_POST['np_chalaniDate'] ?? null;
                $accountNumber = $_POST['np_accountNumber'] ?? null;
                $citizenNumber = $_POST['np_citizenNumber'] ?? null;
                $name = $_POST['np_name'] ?? null;
                break;

            default:
                echo "Invalid department selected!";
                exit;
        }

        // Function to convert Nepali date digits to symbols
        function convertNepaliDateToSymbols($nepaliDate)
        {
            // Mapping Nepali digits to their corresponding symbols
            $nepaliToSymbol = [
                '1' => '!',
                '2' => '@',
                '3' => '#',
                '4' => '$',
                '5' => '%',
                '6' => '^',
                '7' => '&',
                '8' => '*',
                '9' => '(',
                '0' => ')',
                '/' => '÷'
            ];

            // Replace each Nepali digit with the corresponding symbol
            $convertedDate = str_replace(array_keys($nepaliToSymbol), array_values($nepaliToSymbol), $nepaliDate);

            return $convertedDate;
        }

        // Create an instance of the NepaliDate class
        $obj = new NepaliDate();

        // Get the current AD date
        $currentAdDate = date('Y-m-d');
        list($year, $month, $day) = explode('-', $currentAdDate);

        // Convert the current AD date to BS (Nepali date)
        $currentNepaliDate = $obj->convertAdToBs($year, $month, $day);

        // Nepali date in YYYY-MM-DD format
        $np_date = "{$currentNepaliDate['year']}/{$currentNepaliDate['month']}/{$currentNepaliDate['day']}";

        // Convert Nepali date digits to symbols
        $convertedDate = convertNepaliDateToSymbols($np_date);


        // Function to convert Nepali date digits to symbols
        function convertNepaliDateToNP_Symbols($nepaliDate)
        {
            // Mapping Nepali digits to their corresponding symbols
            $nepaliToSymbol = [
                '१' => '!', // Nepali 1
                '२' => '@', // Nepali 2
                '३' => '#', // Nepali 3
                '४' => '$', // Nepali 4
                '५' => '%', // Nepali 5
                '६' => '^', // Nepali 6
                '७' => '&', // Nepali 7
                '८' => '*', // Nepali 8
                '९' => '(', // Nepali 9
                '०' => ')', // Nepali 0
                '/' => '÷'   // Nepali slash
            ];

            // Replace each Nepali digit with the corresponding symbol
            $np_convertedDate = str_replace(array_keys($nepaliToSymbol), array_values($nepaliToSymbol), $nepaliDate);

            return $np_convertedDate;
        }

        if ($chalaniDate) {
            $converted_chalaniDate = convertNepaliDateToNP_Symbols($chalaniDate);
        }


        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section = $phpWord->addSection(
            [
                'paperSize' => 'A4',
                'marginLeft' => 1296, // 0.90" Left margin in twips
                'marginRight' => 1152, // 0.80" Right margin in twips
                'marginTop' => 360,  // 0.25" Top margin in twips
                'marginBottom' => 475,  // 0.33" Bottom margin in twips
            ]
        );


        // Add first page header
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $table->addCell(4500)->addImage(__DIR__ . '/static/img/logo/logo.png', ['width' => 280.32, 'height' => 84.48, 'alignment' => PhpOffice\PhpWord\SimpleType\Jc::START]);
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun(['alignment' => PhpOffice\PhpWord\SimpleType\Jc::END]);

        $textrun->addText(
            'k|wfg sfof{no',
            array('name' => 'ARAP 009', 'size' => 16, 'bold' => true)
        );
        $textrun->addTextBreak();

        $textrun->addText(
            'sDKnfoG; ljefu',
            array('name' => 'ARAP 009', 'size' => 16)
        );
        $textrun->addTextBreak();

        $textrun->addText(
            'wd{ky, sf7df8f}+ .',
            array('name' => 'ARAP 009', 'size' => 16)
        );

        $header->addWatermark(__DIR__ . '/static/img/watermark.png');

        // Add a straight line
        $section->addShape(
            'line', // Shape type
            [
                'points' => '1,1 600,1', // Straight horizontal line from (1,1) to (300,1)
                'outline' => [
                    'color' => '#000000', // Black color
                    'line' => 'single', // Solid line
                    'weight' => 1, // Thin line (1pt)
                    'startArrow' => 'none', // No arrowhead at the start
                    'endArrow' => 'none', // No arrowhead at the end
                ],
            ]
        );


        // Define paragraph style with a right-aligned tab stop
        $phpWord->addParagraphStyle('TabStyle', [
            'tabs' => [
                new \PhpOffice\PhpWord\Style\Tab('right', 9000), // Right-aligned tab at 9000 twips (~6.25 inches)
            ],
        ]);

        // Add text with a tab to move "मिति" to the end
        $section->addText(
            "k=;+=M k|=sf=!÷s=lj=÷*!÷\tldltM $convertedDate",
            ['name' => 'ARAP 009', 'size' => 14],
            'TabStyle'
        );

        $section->addShape(
            'line', // Shape type
            [
                'points' => '1,1 600,1', // Straight horizontal line from (1,1) to (300,1)
                'outline' => [
                    'color' => '#000000', // Black color
                    'line' => 'single', // Solid line
                    'weight' => 1, // Thin line (1pt)
                    'startArrow' => 'none', // No arrowhead at the start
                    'endArrow' => 'none', // No arrowhead at the end
                ],
            ]
        );

        // Paragraph change space
        $section->addText(
            "",
            ['name' => 'ARAP 009', 'size' => 16],
        );

        // Print department specific fields
        if ($department === 'DMLI') {

            // TO
            $section->addText(
                ">L ;DklQ z'4Ls/0f cg';Gwfg ljefu,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "k'Nrf]s, nlntk'/ .",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Subject
            $section->addText(
                "ljifoM a}+s vftfsf] :6]6d]G6 pknAw u/fO{Psf] ;DaGwdf .",
                ['name' => 'ARAP 009', 'size' => 16],
                ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 12],
            );

            // Add text run
            $textrun = $section->addTextRun();
            $textrun->addText(
                "pk/f]Qm ;DaGwdf txfFsf] k=;+=M @)*!÷)*@, rnfgL g+= ",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun->addText($chalaniNumber, ['size' => 16]);
            $textrun->addText(", ldlt $converted_chalaniDate  sf] kq k|fKt u/L Joxf]/f cjut eof] .", ['name' => 'ARAP 009', 'size' => 16]);

            $section->addText(
                "  pQm kqdf pNn]v ePsf] tkl;ndf pNn]lvt vftfx? pNn]lvt JolQmsf] gfddf ;+rfngdf /x]sf] / pQm vftfx?sf] z'? b]lv xfn;Ddsf]] a}+s :6]6d]G6 o;} ;fy ;+nUg u/L txfF k7fO{Psf] Joxf]/f cg'/f]w 5 .",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            $section->addText(
                "tkl;nM",
                ['name' => 'ARAP 009', 'size' => 16],
                ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );

            // Create a table
            $table = $section->addTable();

            $table->addRow();

            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('qm=;+=', ['name' => 'ARAP 009', 'size' => 16]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('vftfjfnfsf] gfd', ['name' => 'ARAP 009', 'size' => 16]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('a}s vftf g+=', ['name' => 'ARAP 009', 'size' => 16]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('vftfsf] k|sf/', ['name' => 'ARAP 009', 'size' => 16]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('xfnsf] df}Hbft ?=÷ -shf{ ?=_', ['name' => 'ARAP 009', 'size' => 16]);

            $table->addRow();
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('!', ['name' => 'ARAP 009', 'size' => 12, 'bold' => true], ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);

            $table->addRow();
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('@', ['name' => 'ARAP 009', 'size' => 12, 'bold' => true], ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);

            $table->addRow();
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('#', ['name' => 'ARAP 009', 'size' => 12, 'bold' => true], ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);

            $table->addRow();
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('$', ['name' => 'ARAP 009', 'size' => 12, 'bold' => true], ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
            $table->addCell(2000, array(
                'borderColor' => '000000',
                'borderSize' => 2,
            ))->addText('', ['name' => 'ARAP 009', 'size' => 12]);
        }

        if ($department === 'SupremeCourt') {
            // TO
            $section->addText(
                ">L sf7df08f]} lhNnf cbfnt,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "aa/dxn, sf7df08f},",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "-kmfF6 g+=–(_,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "d'2f g+= ",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Subject
            $section->addText(
                "ljifoM ljj/0f v'nfO{ a}+s :6]6d]G6 k7fO{Psf] ;DaGwdf .",
                ['name' => 'ARAP 009', 'size' => 16],
                ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 12],
            );

            $textrun = $section->addTextRun();
            $textrun->addText(
                "pk/f]Qm ;DaGwdf ;Ddflgt cbfntsf] ldlt $converted_chalaniDate ut]sf] k=;+M )*!÷)*@, rnfgL g+= ",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun->addText(
                "$chalaniNumber",
                ['size' => 16]
            );
            $textrun->addText(
                " sf] kq k|fKt u/L Joxf]/f cjut eof] .",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun->addText(
                "pQm kqdf pNn]v ePsf] art vftf g+= ",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun->addText(
                "$accountNumber ",
                ['size' => 16]
            );
            $textrun->addText(
                "o; a}+ssf] ?s'd zfvfdf g/]Gb| s'df/ /fgf sf] gfddf ;+rfngdf /x]sf] 5 . ",
                ['name' => 'ARAP 009', 'size' => 16]
            );

            $textrun2 = $section->addTextRun();
            $textrun2->addText(
                "  pQm vftfdf xfn df}Hbft ?= ",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun2->addText(
                "$amount $amountInWords",
                ['size' => 16]
            );
            $textrun2->addText(
                " /x]sf] 5 . pQm vftf s'g} lgsfoaf6 /f]Ssf g/x]sf] b]lvG5 . pQm vftfsf] a}+s :6]6d]G6 o;} ;fy ;+nUg u/L k7fO{Psf] Joxf]/f cg'/f]w ub{5f} .",
                ['name' => 'ARAP 009', 'size' => 16]
            );

        }

        if ($department === 'InvalidAccount') {
            // TO
            $section->addText(
                ">L sf7df08f} pkTosf ck/fw cg';Gwfg sfof{no",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "-lkn/–#_, ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "6]s', sf7df08f} .",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Subject
            $section->addText(
                "ljifoM hfgsf/L u/fO{Psf] ;DaGwdf .",
                ['name' => 'ARAP 009', 'size' => 16],
                ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 12],
            );

            $textrun = $section->addTextRun();
            $textrun->addText(
                "pk/f]Qm ;DaGwdf txfFsf] k=;+=M @)*!÷)*@, rnfgL g+= ",
                ['name' => 'ARAP 009', 'size' => 16]
            );
            $textrun->addText(
                "$chalaniNumber ",
                ['size' => 16]
            );
            $textrun->addText(
                "ldlt $converted_chalaniDate sf] kq O{d]n dfkm{t ldlt @)*!÷)*÷!^ k|fKt u/L Joxf]/f cjut eof] . ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2 = $section->addTextRun();
            $textrun2->addText(
                "  pQm kqdf pNn]v ePsf] vftf g+= ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2->addText(
                "$accountNumber ",
                ['size' => 16]
            );
            $textrun2->addText(
                "o; a}+sdf g/x]sf] / o; a}+ssf] xfnsf] vftf g+= 20 Digits  sf] /x]sf] Joxf]/f hfgsf/Lsf] nflu cg'/f]w ub{5f}+ .",
                ['name' => 'ARAP 009', 'size' => 16],
            );

        }
        if ($department === 'NepalPoliceHeadOffice') {
            // TO
            $section->addText(
                ">L g]kfn k|x/L k|wfg sfof{no,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "k|x/L dxflg/LIfssf] ;lrjfno,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                ";'kl/j]If0f tyf cg'udg dxfzfvf,",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "-ph'/L 5fglag zfvf_, ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $section->addText(
                "gS;fn, sf7df08f} .",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 16],
            );

            // Subject
            $section->addText(
                "ljifoM ljj/0f pknAw u/fO{Psf] ;DaGwdf .",
                ['name' => 'ARAP 009', 'size' => 16],
                ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]
            );

            // Paragraph change space
            $section->addText(
                "",
                ['name' => 'ARAP 009', 'size' => 12],
            );

            $textrun = $section->addTextRun();
            $textrun->addText(
                "pk/f]Qm ;DaGwdf txfFsf] k=;+=M @)*!÷)*@, rnfgL g+= ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun->addText(
                "$chalaniNumber ",
                ['size' => 16],
            );
            $textrun->addText(
                "ldlt $converted_chalaniDate sf] kq O{d]n dfkm{t k|fKt u/L Joxf]/f cjut eof] . ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2 = $section->addTextRun();
            $textrun2->addText(
                "  pQm kqdf pNn]v ePsf] art vftf g+= ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2->addText(
                "$accountNumber ",
                ['size' => 16],
            );
            $textrun2->addText(
                "o; a}+ssf] O{nfd zfvfdf ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2->addText(
                "$name ",
                ['size' => 16],
            );
            $textrun2->addText(
                "-gf=k|=k=g+= ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
            $textrun2->addText(
                "$citizenNumber ",
                ['size' => 16],
            );
            $textrun2->addText(
                ", vf]6fª_ sf] gfddf ;+rfngdf /x]sf] 5 . vftfjfnfn] pQm vftf vf]Nbfsf avt k]z u/]sf sfuhftx?– JolQmut vftf vf]Ng] kmf/d, JolQmut KYC, gful/stf k|df0fkqsf] 5fofF slk o;} ;fy ;+nUg u/L txfF k7fO{Psf] Joxf]/f cg'/f]w 5 . ",
                ['name' => 'ARAP 009', 'size' => 16],
            );
        }

        // Paragraph change space
        $section->addText(
            "",
            ['name' => 'ARAP 009', 'size' => 16],
        );


        $section->addText(
            "ejbLo,",
            ['name' => 'ARAP 009', 'size' => 16],
            ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::END]
        );

        // Empty space for signature
        $section->addText(
            "",
            ['name' => 'ARAP 009', 'size' => 16],
            ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::END]
        );

        $section->addText(
            "===================",
            ['name' => 'ARAP 009', 'size' => 16],
            ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::END]
        );


        // Add first page header
        $footer = $section->addFooter();
        $footer->firstPage();

        // $footer->addWatermark(__DIR__ . '/static/img/image.png');

        $footer->addImage(__DIR__ . '/static/img/footer.png', ['width' => 480, 'height' => 34]);

        // // Add text to the footer
        // $footer->addText('This is the footer text.', ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::CENTER]);

        // // Rectangle
        // $footer->addShape(
        //     'rect',
        //     [
        //         'roundness' => 10000,
        //         'frame' => ['width' => 460, 'height' => 10],
        //         'fill' => ['color' => '#FF0000'],
        //         'outline' => ['color' => '#FF0000', 'weight' => 30],
        //         'shadow' => [],
        //         ['alignment' => PhpOffice\PhpWord\SimpleType\Jc::START]

        //     ],

        // );

        $directory = "generated_docs";
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true); // Create directory with write permissions
        }

        // foreach (glob($directory . "/*.docx") as $existingFile) {
        //     unlink($existingFile);
        // }

        $timestamp = date("Y-m-d_H-i-s");

        // Saving the document as Word2007 (.docx) with a unique name
        $docFileName = "generated_docs/doc_{$timestamp}.docx";
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($docFileName);

        // // Saving the document as HTML (.html) with a unique name
        // $htmlFileName = "/tmp/web_{$timestamp}.html";
        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        // $objWriter->save($htmlFileName);

        // echo "<br>Word file saved as: " . $docFileName;
        // echo "<br>HTML file saved as: " . $htmlFileName;
        ?>

        <!-- HTML for the page -->
        <div class="container">
            <h2>Document Saved Successfully!</h2>
            <p>Your files have been saved successfully for the <strong><?php echo htmlspecialchars($department); ?></strong>
                department.</p>
            <p>You can download the DOCX file using the link below:</p>

            <!-- Provide a link to the saved DOCX file -->
            <a href="generated_docs/doc_<?php echo $timestamp; ?>.docx" download class="download-button">Download DOCX File</a>
            <br>
            <p><a href="index.php" class="home-button">Return to Home</a></p>
        </div>

        <?php


    } else {
        echo '<div class="error-message">Invalid request method.</div>';
    }
} catch (Exception $e) {
    // Handle any errors that occurred during the process
    echo '<div class="error-message">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}

?>