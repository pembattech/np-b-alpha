<?php
// Usage
include_once 'is_login.php';
checkLogin();

include_once 'navbar.php';
?>
<div class="container">

    <div class="chitipatra_form">

        <h1>Chitira Patra</h1>

        <form id="chitiraPatraForm">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject">
                <option value="">Select Subject</option>
                <option value="विवरण उपलब्य गरा्ईएको सम्बन्धमा ।">विवरण उपलब्य गरा्ईएको सम्बन्धमा ।</option>
                <option value="रोक्का सम्बन्धमा ।">रोक्का सम्बन्धमा ।</option>
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
                <div>
                    <button type="submit" id="submitButton">Submit</button>
                    <button type="button" id="resetButton">Reset</button>
                </div>
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
            <p id="nepali-date"></p>
        </div>
        <hr>



        <p><span id="printDepartment"></span></p>

        <p class="subject"><strong>विषयः</strong> <span id="printSubject"></span></p>

        <div id="printContent"></div>

        <div class="heading-left">
            <p>प्रघान कार्यांलय</p>
            <p>कम्प्लायन्स विभाग</p>
            <p>धर्मपथ, काठमाडौ ।</p>
        </div>
    </div>
    <hr>

    <div class="pno_date">
        <p class="p_no">प.सं: प्र.१./ क.वि./द७/</p>
        <p id="nepali-date"></p>
    </div>
    <hr>


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
                फोन नं.
            </p>
            <p class="phone_num">
                <span>
                    ०१-५९७११६५
                </span>
                <span>
                    ०१-५३३२५००
                </span>
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
                ['view', ['codeview']],
                ['table']

            ]
        });
    });

    // Get the current date
    function convertToNepaliNumbers(number) {
        const englishToNepali = {
            '0': '०',
            '1': '१',
            '2': '२',
            '3': '३',
            '4': '४',
            '5': '५',
            '6': '६',
            '7': '७',
            '8': '८',
            '9': '९',
        };

        // Pad with zero if the number is less than 10
        const paddedNumber = number < 10 ? '0' + number : number.toString();

        // Convert to Nepali numbers
        return paddedNumber.split('').map(num => englishToNepali[num] || num).join('');
    }

    const d = new NepaliDate();
    const bsDate = d.getBS();

    const nepaliYear = convertToNepaliNumbers(bsDate.year);
    const nepaliMonth = convertToNepaliNumbers(bsDate.month + 1);
    const nepaliDate = convertToNepaliNumbers(bsDate.date);
    document.getElementById('nepali-date').innerText = `मितिः${nepaliYear}/${nepaliMonth}/${nepaliDate}`;

    // Form Elements
    const chitiraPatraForm = document.getElementById('chitiraPatraForm');
    const printButton = document.getElementById('printButton');
    const printSubject = document.getElementById('printSubject');
    const printDepartment = document.getElementById('printDepartment');
    const printContent = document.getElementById('printContent');

    // Error Display Function
    function displayError(input, message) {
        const errorElement = document.createElement('p');
        errorElement.textContent = message;
        errorElement.classList.add('error');
        input.insertAdjacentElement('afterend', errorElement);
    }

    // Clear Existing Errors
    function clearErrors() {
        const errors = document.querySelectorAll('.error');
        errors.forEach(error => error.remove());
    }

    // Validate Form
    function validateForm() {
        clearErrors();

        let isValid = true;

        // Validate Subject
        const subject = document.getElementById('subject');
        if (subject.value.trim() === '') {
            displayError(subject, 'Please select a subject.');
            isValid = false;
        }

        // Validate Department
        const department = document.getElementById('department');
        if (department.value.trim() === '') {
            displayError(department, 'Please select a department.');
            isValid = false;
        }

        // Validate Content
        const content = $('.summernote').summernote('code').trim();
        if (content === '' || content === '<p><br></p>') {
            displayError(document.querySelector('.note-editor'), 'Content cannot be empty.');
            isValid = false;
        }

        return isValid;
    }

    // Handle form submission
    chitiraPatraForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validate Form
        if (validateForm()) {
            // Get subject, department, and content values
            const subject = document.getElementById('subject').value;
            const department = document.getElementById('department').value;
            const content = $('.summernote').summernote('code');

            // Update the print area
            printSubject.textContent = subject || 'N/A';
            printDepartment.textContent = department || 'N/A';
            printContent.innerHTML = content;

            alert('Form Submitted and Print Area Updated!');
        }
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

    resetButton.addEventListener('click', function () {
        document.getElementById('subject').value = '';
        document.getElementById('department').value = '';
        $('.summernote').summernote('reset'); // Reset Summernote content
        printSubject.textContent = '';
        printDepartment.textContent = '';
        printContent.innerHTML = '';
        alert('Form has been reset!');
    });
</script>
</body>

</html>