<!DOCTYPE html>
<html>
<head>
    <title>Hi</title>
</head>
<body>
    <h1>TESTING PDF VIEW</h1>
    <p>Test 2</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    <img src="{{asset('storage/image/kartu.png')}}" style="width: 100%;">
    {{-- @php
        // $image
        // $imageData = base64_encode(file_get_contents('img/E-Kartu_Alumni_UNS.png'));
        // $src = 'data'. mime_content_type()
        $path = asset('storage/image/E-Kartu_Alumni_UNS.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp
    <img src="<?= $base64 ?>" style="width: 100%;"> --}}
</body>
</html>