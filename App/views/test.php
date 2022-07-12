<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        // use App\Models\Kit;
        use Illuminate\Database\Capsule\Manager as Capsule;

        $kits = Capsule::table('kits')->get();

        var_dump($kits);

    ?>
</body>
</html>