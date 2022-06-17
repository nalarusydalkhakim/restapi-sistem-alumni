<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        @page { margin: 5px; }
        body { 
            margin: 5px;
            font-family: sans-serif;
        }
        table, th, td {
            /* border: 0.1px solid; */
            padding: 3px;
            font-size: 14px;
        }
        .front{
            color: #13B9F5;
            font-weight: bold;
        }
        .photo{
            width: 227px;
            height: 270px;
            /* align: top; */
            /* display: inline-block; */
            float: top;
            padding-top: 6px;
            padding-left: 4px;
            padding-right: 0px;
        }
    </style>
</head>
{{-- 342px 429px ktp size --}}
<body style="background-image: url({{ public_path("storage/image/kartu_update_1.png") }});background-size: 100% ;background-repeat: no-repeat;">
    <table width="98%" style="padding: 170px 5px 5px 5px;">
        <tr>
            <td width="20%" class="front">Nama</td>
            <td width="5%">:</td>
            <td>{{ $name }}</td>
            <td rowspan="15" width="32%" style="padding-right: 0px;">
                <img src="{{ public_path("storage/".$photo) }}" class="photo"  alt="">
            </td>
        </tr>
        <tr>
            <td class="front">NIK</td>
            <td>:</td>
            <td>{{ $nik }}</td>
        </tr>
        <tr>
            <td class="front">Nomor Anggota</td>
            <td>:</td>
            <td>{{ $no_member }}</td>
        </tr>
        <tr>
            <td class="front">Tempat & Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $birth }}</td>
        </tr>
        <tr>
            <td class="front">Fakultas/Prodi</td>
            <td>:</td>
            <td>{{ $fac_dep }}</td>
        </tr>
        <tr>
            <td class="front">Lulus Tahun</td>
            <td>:</td>
            <td>{{ $graduate_year }}</td>
        </tr>
        <tr>
            <td height="20px"></td>
        </tr>
        <tr>
            <td class="front">Kedaluwarsa</td>
            <td>:</td>
            <td>{{ $expired_date }}</td>
        </tr>
        <tr>
            <td height="10px"></td>
        </tr>
        <tr>
            <td colspan="3" style="font-size: 6px;">ISI TRACER STUDY KEMBALI UNTUK MEMPERBARUI MASA KEDALUWARSA</td>
        </tr>
        <tr>
            <td colspan="3"><div>{!! DNS1D::getBarcodeHTML($nik, 'C128') !!}</div></td>
        </tr>
    </table>
    <table  style="margin-top: 50px;margin-left: auto;margin-right: auto;">
        <tr>
            <td>
                <div style="margin-left: auto;margin-right: auto;">{!! DNS2D::getBarcodeHTML($nik, 'QRCODE') !!}</div>
            </td>
        </tr>
    </table>
</body>
</html>