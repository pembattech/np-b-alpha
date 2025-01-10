<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chitira Patra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">


    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        hr {
            margin: 0;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .print-area {
            margin-top: 20px;
            width: 90%;        
        }

        h1 {
            font-size: 28px;
            color: #1976d2;
            margin-bottom: 30px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #424242;
        }

        select,
        .summernote {
            font-size: 14px;
            padding: 10px;
            border: 1px solid #bdbdbd;
            border-radius: 5px;
            outline: none;
            width: 100%;
            box-sizing: border-box;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        button {
            font-size: 14px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        #submitButton {
            background-color: #1976d2;
            color: #ffffff;
        }

        #submitButton:hover {
            background-color: #1565c0;
        }

        #printButton {
            background-color: #43a047;
            color: #ffffff;
        }

        #printButton:hover {
            background-color: #388e3c;
        }

        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 210mm;
                height: 297mm;
                padding: 20mm;
                box-sizing: border-box;
                font-size: 16px;
                color: #000;
                line-height: 1.5;
            }
        }


        .heading {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .logo img {
            width: 250px;
        }

        .heading p {
            margin: 0;
        }

        .pno_date {
            display: flex;
            justify-content: space-between;
        }

        .subject {
            text-align: center;
            text-decoration: underline;
        }

        .footer {
            background-image: linear-gradient(to right, #3150a1 0%, #142f73 100%);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            color: #ffffff;
        }

        .footer p {
            margin: 0;
        }

        .footer .nepal_first_bank {
            text-align: right;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Chitira Patra</h1>

        <form id="chitiraPatraForm">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject">
                <option value="">Select Subject</option>
                <option value="विवरण उपलब्य गरा्ईएको सम्बन्यमा ।">Bbiran</option>
                <option value="rokha">Rokha</option>
            </select>

            <label for="department">Select Department:</label>
            <select id="department" name="department">
                <option value="">Select Department</option>
                <option value="Mr. Money Laundering Invetigation Department">DMLI</option>
                <option value="Central Investigation Bureau">CIB</option>
                <option value="Supreme Court">Supreme Court</option>
                <option value="Inland Revenue Department">Inland Revenue Department</option>
            </select>

            <label for="content">Content:</label>
            <textarea id="content" class="summernote"></textarea>

            <div class="button-group">
                <button type="submit" id="submitButton">Submit</button>
                <button type="button" id="printButton">Print</button>
            </div>
        </form>
    </div>

    <!-- Print Area -->
    <div id="printArea" class="print-area">
        <div class="heading">
            <div class="logo">
                <img src="https://nepalbank.com.np/frontend/images/logo.png">
            </div>

            <div class="heading-left">
                <p>प्रघान कार्यांलय</p>
                <p>कम्प्लायन्स विभाग</p>
                <p>धर्मपथ, काठमाडौ ।</p>
            </div>
        </div>
        <hr>

        <div class="pno_date">
            <p class="p_no">प.सं: प्र.१./ क.वि./द७/</p>
            <p id="currentDate"></p>
        </div>
        <hr>

        <p><span id="printDepartment"></span></p>

        <p class="subject"><strong>विषयः</strong> <span id="printSubject"></span></p>

        <div id="printContent"></div>

        <div style="
         display: flex;
        flex-direction: column;
        align-items:end;
        gap: 0.5rem;">

            <p>भवदीय,</p>

            <p>..........</p>

        </div>
        <div class="footer">
            <div class="left-footer">
                <p>
                    फोन नं. ०१-५९७११६५
                </p>
                <p>
                    ०१-५३३२५००
                </p>
            </div>

            <div class="right-footer">
                <p class="nepal_first_bank">
                    नेपालको पहिलो बैँक
                </p>
                <p>
                    Email: compliance@nepalbank.com.np Website www.nepalbank.com.np
                </p>
            </div>



        </div>
    </div>

    <script>
        // Initialize Summernote
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });

        // Get the current date
        const dateElement = document.getElementById('currentDate');
        const currentDate = new Date().toLocaleDateString();
        dateElement.textContent = `मितिः${currentDate}`;

        // Form Elements
        const chitiraPatraForm = document.getElementById('chitiraPatraForm');
        const printButton = document.getElementById('printButton');
        const printSubject = document.getElementById('printSubject');
        const printDepartment = document.getElementById('printDepartment');
        const printContent = document.getElementById('printContent');

        // Handle form submission
        chitiraPatraForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get subject, department, and content values
            const subject = document.getElementById('subject').value;
            const department = document.getElementById('department').value;
            const content = $('.summernote').summernote('code');

            // Update the print area
            printSubject.textContent = subject || 'N/A';
            printDepartment.textContent = department || 'N/A';
            printContent.innerHTML = content;

            alert('Form Submitted and Print Area Updated!');
        });

        // Handle printing
        printButton.addEventListener('click', function () {
            if (
                printSubject.textContent.trim() === '' ||
                printDepartment.textContent.trim() === '' ||
                printContent.innerHTML.trim() === ''
            ) {
                alert('Please submit the form to populate the print area.');
            } else {
                window.print();
            }
        });
    </script>
</body>

</html>