<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f4f7fa;
    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto;
    }

    select,
    input,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    button {
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .bod-picker {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    #clear-bth {
        background-color: #dc3545;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
    }

    #clear-bth:hover {
        background-color: #c82333;
    }

    div[id$='-fields'] {
        margin-bottom: 20px;
    }

    div[id$='-fields'] label,
    div[id$='-fields'] input {
        margin-bottom: 10px;
    }

    .error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
</style>

<!-- jQuery Script: Make sure it's loaded first -->
<script src="//code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Nepali Date Picker -->
<script src="//unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.js"></script>
<link rel="stylesheet" href="//unpkg.com/nepali-date-picker@2.0.2/dist/nepaliDatePicker.min.css">

<form action="docx_process.php" method="POST">
    <select id="department" name="department" required>
        <option value="">Select Department</option>
        <option value="DMLI">Mr. Asset Laundering Investigation Department</option>
        <option value="SupremeCourt">Supreme Court</option>
        <option value="InvalidAccount">Invalid Account</option>
        <option value="NepalPoliceHeadOffice">Nepal Police Head Office</option>
    </select>

    <!-- DMLI Fields -->
    <div id="dmli-fields" style="display: none;" aria-hidden="true">
        <label for="dmli_chalaniNumber">Chalani Number:</label>
        <input type="number" name="dmli_chalaniNumber" id="dmli_chalaniNumber">
        <div id="dmli_chalaniNumber-error" class="error"></div>

        <label for="dmli_chalaniDate">Chalani Date:</label>
        <input type="text" name="dmli_chalaniDate" class="bod-picker" id="dmli_chalaniDate"
            placeholder="Select Date of Chalani">
        <div id="dmli_chalaniDate-error" class="error"></div>
        <button id="clear-bth" type="button">Clear</button>
    </div>

    <!-- Supreme Court Fields -->
    <div id="supremecourt-fields" style="display: none;" aria-hidden="true">
        <label for="supreme_chalaniNumber">Chalani Number:</label>
        <input type="number" name="supreme_chalaniNumber" id="supreme_chalaniNumber">
        <div id="supreme_chalaniNumber-error" class="error"></div>

        <label for="supreme_chalaniDate">Chalani Date:</label>
        <input type="text" name="supreme_chalaniDate" class="bod-picker" id="supreme_chalaniDate">
        <div id="supreme_chalaniDate-error" class="error"></div>

        <label for="supreme_accountNumber">Account Number:</label>
        <input type="number" name="supreme_accountNumber" id="supreme_accountNumber">
        <div id="supreme_accountNumber-error" class="error"></div>

        <label for="supreme_amount">Amount:</label>
        <input type="number" name="supreme_amount" id="supreme_amount">
        <div id="supreme_amount-error" class="error"></div>

        <label for="supreme_amountInWords">Amount in Words:</label>
        <input type="text" name="supreme_amountInWords" id="supreme_amountInWords">
        <div id="supreme_amountInWords-error" class="error"></div>
    </div>

    <!-- Invalid Account Fields -->
    <div id="invalidaccount-fields" style="display: none;" aria-hidden="true">
        <label for="invalid_chalaniNumber">Chalani Number:</label>
        <input type="number" name="invalid_chalaniNumber" id="invalid_chalaniNumber">
        <div id="invalid_chalaniNumber-error" class="error"></div>

        <label for="invalid_chalaniDate">Chalani Date:</label>
        <input type="text" name="invalid_chalaniDate" class="bod-picker" id="invalid_chalaniDate">
        <div id="invalid_chalaniDate-error" class="error"></div>

        <label for="invalid_accountNumber">Account Number:</label>
        <input type="number" name="invalid_accountNumber" id="invalid_accountNumber">
        <div id="invalid_accountNumber-error" class="error"></div>
    </div>

    <!-- Nepal Police Head Office Fields -->
    <div id="nepalpoliceheadoffice-fields" style="display: none;" aria-hidden="true">
        <label for="np_chalaniNumber">Chalani Number:</label>
        <input type="number" name="np_chalaniNumber" id="np_chalaniNumber">
        <div id="np_chalaniNumber-error" class="error"></div>

        <label for="np_chalaniDate">Chalani Date:</label>
        <input type="text" name="np_chalaniDate" class="bod-picker" id="np_chalaniDate">
        <div id="np_chalaniDate-error" class="error"></div>

        <label for="np_accountNumber">Account Number:</label>
        <input type="number" name="np_accountNumber" id="np_accountNumber">
        <div id="np_accountNumber-error" class="error"></div>

        <label for="np_citizenNumber">Citizen Number:</label>
        <input type="number" name="np_citizenNumber" id="np_citizenNumber">
        <div id="np_citizenNumber-error" class="error"></div>

        <label for="np_name">Name:</label>
        <input type="text" name="np_name" id="np_name">
        <div id="np_name-error" class="error"></div>
    </div>

    <button type="submit">Submit</button>
</form>

<script>
    $(document).ready(function () {
        // Hide all the department fields initially
        $('div[id$="-fields"]').hide();

        // Show corresponding department fields when a department is selected
        $('#department').on('change', function () {
            const department = $(this).val();
            console.log(department);
            $('div[id$="-fields"]').hide();
            $('#' + department.toLowerCase() + '-fields').show();
        });

        // Date picker initialization
        $(".bod-picker").nepaliDatePicker({
            dateFormat: "%y/%m/%d",
        });

        // Clear button functionality
        $('#clear-bth').click(function () {
            $(this).closest('form').find("input[type=text], input[type=number]").val('');
            $('#department').val('');
        });

        // Form validation on submit
        $('form').on('submit', function (e) {
            let isValid = true;
            const department = $('#department').val();

            // Clear any previous error messages
            $('.error').text('');

            // Check if department is selected
            if (!department) {
                $('#department-error').text('Please select a department.');
                isValid = false;
            }

            // Validate fields based on department selection
            if (department === 'DMLI') {
                if (!$('#dmli_chalaniNumber').val()) {
                    $('#dmli_chalaniNumber-error').text('Please enter Chalani Number for DMLI.');
                    isValid = false;
                }
                if (!$('#dmli_chalaniDate').val()) {
                    $('#dmli_chalaniDate-error').text('Please select Chalani Date for DMLI.');
                    isValid = false;
                }
            } else if (department === 'SupremeCourt') {
                if (!$('#supreme_chalaniNumber').val()) {
                    $('#supreme_chalaniNumber-error').text('Please enter Chalani Number for Supreme Court.');
                    isValid = false;
                }
                if (!$('#supreme_chalaniDate').val()) {
                    $('#supreme_chalaniDate-error').text('Please select Chalani Date for Supreme Court.');
                    isValid = false;
                }
                if (!$('#supreme_accountNumber').val()) {
                    $('#supreme_accountNumber-error').text('Please enter Account Number for Supreme Court.');
                    isValid = false;
                }
                if (!$('#supreme_amount').val()) {
                    $('#supreme_amount-error').text('Please enter Amount for Supreme Court.');
                    isValid = false;
                }
                if (!$('#supreme_amountInWords').val()) {
                    $('#supreme_amountInWords-error').text('Please enter Amount in Words for Supreme Court.');
                    isValid = false;
                }
            } else if (department === 'InvalidAccount') {
                if (!$('#invalid_chalaniNumber').val()) {
                    $('#invalid_chalaniNumber-error').text('Please enter Chalani Number for Invalid Account.');
                    isValid = false;
                }
                if (!$('#invalid_chalaniDate').val()) {
                    $('#invalid_chalaniDate-error').text('Please select Chalani Date for Invalid Account.');
                    isValid = false;
                }
                if (!$('#invalid_accountNumber').val()) {
                    $('#invalid_accountNumber-error').text('Please enter Account Number for Invalid Account.');
                    isValid = false;
                }
            } else if (department === 'NepalPoliceHeadOffice') {
                if (!$('#np_chalaniNumber').val()) {
                    $('#np_chalaniNumber-error').text('Please enter Chalani Number for Nepal Police Head Office.');
                    isValid = false;
                }
                if (!$('#np_chalaniDate').val()) {
                    $('#np_chalaniDate-error').text('Please select Chalani Date for Nepal Police Head Office.');
                    isValid = false;
                }
                if (!$('#np_accountNumber').val()) {
                    $('#np_accountNumber-error').text('Please enter Account Number for Nepal Police Head Office.');
                    isValid = false;
                }
                if (!$('#np_citizenNumber').val()) {
                    $('#np_citizenNumber-error').text('Please enter Citizen Number for Nepal Police Head Office.');
                    isValid = false;
                }
                if (!$('#np_name').val()) {
                    $('#np_name-error').text('Please enter Name for Nepal Police Head Office.');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>