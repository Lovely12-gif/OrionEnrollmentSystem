<?php
session_start();
session_regenerate_id(true);

include '../Config/connecttodb.php';

$message = "";

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Username'])) {
    $Username = trim($_POST['Username']);
    $Password = trim($_POST['Password']);

    if (!empty($Username) && !empty($Password)) {
        $stmt = $conn->prepare("SELECT Password FROM user WHERE LOWER(Username) = LOWER(?)");

        if ($stmt) {
            $stmt->bind_param("s", $Username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Debugging: Print password hash
                echo "<p>Stored Hash: " . htmlspecialchars($row['Password']) . "</p>";
                echo "<p>Entered Password: " . htmlspecialchars($Password) . "</p>";

                if (password_verify($Password, $row['Password'])) {
                    echo "<p style='color:green;'>✅ Password matched!</p>";
                    $_SESSION['Username'] = $Username;
                    header("Location: ../Config/layout.php");
                    exit();
                } else {
                    echo "<p style='color:red;'>❌ Password did not match!</p>";
                }
            } else {
                echo "<p style='color:red;'>❌ Username not found!</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>❌ Database query error!</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ Please fill in all fields!</p>";
    }
}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Orbitron', sans-serif;
            margin: 0;
            padding: 0;
            background: black;
            color: white;
            text-align: center;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            position: relative;
            z-index: 2;
        }
        .login-box {
            background: rgba(30, 30, 50, 0.9);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
            width: 300px;
        }
        input {
            width: 80%;
            padding: 10px;
            padding-right: 40px;
            margin: 10px 0;
            border: 2px solid #4CAF50;
            border-radius: 8px;
            background: #121232;
            color: white;
            text-align: center;
            font-size: 16px;
        }
        .password-container {
            position: relative;
            width: 100%;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
            font-size: 18px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<!-- Star Constellation Background -->
<canvas id="starCanvas"></canvas>

<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <?php echo $message; ?>
        <form id="authForm" action="login.php" method="post">
            <input type="text" name="Username" placeholder="Username" required><br>
            <div class="password-container">
                <input type="password" name="Password" id="password" placeholder="Password" required>
                <span class="toggle-password" id="toggleIcon" onclick="togglePassword()">👁️‍🗨️</span>
            </div>
            <br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="../User/Userindex.php" style="color: #4CAF50;">Create one</a></p>
    </div>
</div>


<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.textContent = "👁️";
        } else {
            passwordField.type = "password";
            toggleIcon.textContent = "👁️‍🗨️";
        }
    }

    // Star Constellation Background
    const canvas = document.getElementById("starCanvas");
    const ctx = canvas.getContext("2d");

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const stars = [];
    const numStars = 100;

    function Star() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.radius = Math.random() * 2;
        this.speedX = (Math.random() - 0.5) * 0.5;
        this.speedY = (Math.random() - 0.5) * 0.5;
    }

    Star.prototype.update = function () {
        this.x += this.speedX;
        this.y += this.speedY;

        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
    };

    Star.prototype.draw = function () {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = "white";
        ctx.fill();
    };

    for (let i = 0; i < numStars; i++) {
        stars.push(new Star());
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (let i = 0; i < numStars; i++) {
            stars[i].update();
            stars[i].draw();
        }

        for (let i = 0; i < numStars; i++) {
            for (let j = i + 1; j < numStars; j++) {
                let dx = stars[i].x - stars[j].x;
                let dy = stars[i].y - stars[j].y;
                let distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 100) {
                    ctx.beginPath();
                    ctx.moveTo(stars[i].x, stars[i].y);
                    ctx.lineTo(stars[j].x, stars[j].y);
                    ctx.strokeStyle = "rgba(255, 255, 255, 0.2)";
                    ctx.stroke();
                }
            }
        }

        requestAnimationFrame(animate);
    }

    animate();
</script>

</body>
</html>
