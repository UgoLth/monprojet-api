<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue sur notre plateforme</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .credentials {
            background-color: #fff;
            padding: 15px;
            border-left: 4px solid #4a90e2;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenue {{ $proprietaire->prenom }} {{ $proprietaire->nom }}</h1>
    </div>

    <div class="content">
        <p>Nous sommes ravis de vous accueillir sur notre plateforme de gestion de pension pour animaux.</p>
        
        <p>Votre compte a été créé avec succès. Voici vos identifiants de connexion :</p>
        
        <div class="credentials">
            <p><strong>Email :</strong> {{ $proprietaire->email }}</p>
            <p><strong>Mot de passe :</strong> {{ $password }}</p>
        </div>

        <p>Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe lors de votre première connexion.</p>

        <p>Avec ce compte, vous pourrez :</p>
        <ul>
            <li>Gérer vos informations personnelles</li>
            <li>Voir les informations de vos animaux</li>
            <li>Suivre les séjours en pension</li>
        </ul>
    </div>

    <div class="footer">
        <p>Si vous n'êtes pas à l'origine de cette inscription, veuillez nous contacter immédiatement.</p>
    </div>
</body>
</html>
