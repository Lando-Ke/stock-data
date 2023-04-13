<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock App</title>
    <!-- Include Bootstrap and jQuery -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
        }

        .card {
            background-color: white;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 5px;
        }

        .submit-btn {
            background-color: rgb(154, 154, 219);
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <h1 class="text-center">Stock App</h1>
            <form action="{{ route('submit-form') }}" method="POST" id="stock-form" onsubmit="return validateForm();">
                @csrf
                <div class="form-group">
                    <label for="company-symbol">Company Symbol</label>
                    <input type="text" class="form-control" id="company-symbol" name="company-symbol"
                        placeholder="Enter Company Symbol">
                </div>
                <div class="form-group">
                    <label for="start-date">Start Date</label>
                    <input type="text" class="form-control" id="start-date" name="start-date">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <div class="form-group">
                    <label for="end-date">End Date</label>
                    <input type="text" class="form-control" id="end-date" name="end-date">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#start-date").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date()
            });

            $("#end-date").datepicker({
                dateFormat: "yy-mm-dd",
                maxDate: new Date()
            });
            const symbols = @json($symbols);
            $("#company-symbol").autocomplete({
                source: symbols
            });
        });

        function validateForm() {
            let isValid = true;
            let errorMessage = "";

            const companySymbol = $("#company-symbol").val();
            const startDate = $("#start-date").val();
            const endDate = $("#end-date").val();
            const email = $("#email").val();

            if (!companySymbol) {
                errorMessage += "Company Symbol is required.\n";
                isValid = false;
            }

            if (!startDate) {
                errorMessage += "Start Date is required.\n";
                isValid = false;
            } else if (!isValidDate(startDate)) {
                errorMessage += "Start Date must be a valid date.\n";
                isValid = false;
            }

            if (!endDate) {
                errorMessage += "End Date is required.\n";
                isValid = false;
            } else if (!isValidDate(endDate)) {
                errorMessage += "End Date must be a valid date.\n";
                isValid = false;
            }

            if (startDate && endDate && startDate > endDate) {
                errorMessage += "Start Date must be less or equal to End Date.\n";
                isValid = false;
            }

            if (!email) {
                errorMessage += "Email is required.\n";
                isValid = false;
            } else if (!isValidEmail(email)) {
                errorMessage += "Email must be a valid email address.\n";
                isValid = false;
            }

            if (!isValid) {
                alert(errorMessage);
            }

            return isValid;
        }

        function isValidDate(dateString) {
            const dateRegEx = /^\d{4}-\d{2}-\d{2}$/;
            return dateRegEx.test(dateString);
        }

        function isValidEmail(email) {
            const emailRegEx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegEx.test(email);
        }
    </script>
</body>

</html>
