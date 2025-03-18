<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .popup button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .popup button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    
    <div class="popup" id="popup">
        <div class="popup-content">
            <h2>Registration Successful!</h2>
            <p>Welcome to our platform.</p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>

    <script>
        
        function closePopup() {
            document.getElementById("popup").style.display = "none";
            window.location.href = "index.php";
        }

        document.getElementById("popup").style.display = "flex";
    </script>

</body>
</html>
