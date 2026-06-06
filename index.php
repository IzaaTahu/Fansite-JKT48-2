<?php

session_start();
include_once 'app/controllers/UsersControllers.php';

$act        = $_GET['act'] ?? 'home';
$controller = new UsersControllers();

switch ($act) {
    case 'home':                  $controller->index();                break;

    case 'register':              $controller->viewRegister();         break;
    case 'register-process':      $controller->register();             break;
    case 'login':                 $controller->viewLogin();            break;
    case 'login-process':         $controller->login();                break;
    case 'logout':                $controller->logout();               break;

    case 'user':                  $controller->user();                 break;
    case 'mypage':                $controller->mypage();               break;
    case 'update-oshimen':        $controller->updateOshimen();        break;
    case 'update-profile':        $controller->updateProfile();        break;
    case 'member':                $controller->memberPage();           break;
    case 'berita':                $controller->beritaPage();           break;
    case 'jadwal':                $controller->jadwalPage();           break;
    case 'kontak':                $controller->kontakPage();           break;
    case 'galeri':                $controller->galeriPage();           break;

    case 'kirim-saran':           $controller->kirimSaran();           break;
    case 'admin-saran':           $controller->adminSaran();           break;
    case 'admin-saran-delete':    $controller->adminSaranDelete();     break;

    case 'galeri-event':           $controller->galeriEvent();         break;
    case 'galeri-foto':            $controller->galeriFoto();          break;
    case 'galeri-upload':          $controller->galeriUpload();        break;
    case 'galeri-hapus-foto':      $controller->galeriHapusFoto();     break;
    case 'galeri-komentar':        $controller->galeriKomentar();      break;
    case 'galeri-hapus-komentar':  $controller->galeriHapusKomentar(); break;
    case 'admin-galeri':           $controller->adminGaleri();         break;
    case 'admin-galeri-create':    $controller->adminGaleriCreate();   break;
    case 'admin-galeri-store':     $controller->adminGaleriStore();    break;
    case 'admin-galeri-edit':      $controller->adminGaleriEdit();     break;
    case 'admin-galeri-update':    $controller->adminGaleriUpdate();   break;
    case 'admin-galeri-delete':    $controller->adminGaleriDelete();   break;

    case 'admin':                 $controller->admin();                break;

    case 'admin-member':          $controller->adminMember();          break;
    case 'admin-member-create':   $controller->adminMemberCreate();    break;
    case 'admin-member-store':    $controller->adminMemberStore();     break;
    case 'admin-member-edit':     $controller->adminMemberEdit();      break;
    case 'admin-member-update':   $controller->adminMemberUpdate();    break;
    case 'admin-member-delete':   $controller->adminMemberDelete();    break;

    case 'admin-jadwal':          $controller->adminJadwal();          break;
    case 'admin-jadwal-create':   $controller->adminJadwalCreate();    break;
    case 'admin-jadwal-store':    $controller->adminJadwalStore();     break;
    case 'admin-jadwal-edit':     $controller->adminJadwalEdit();      break;
    case 'admin-jadwal-update':   $controller->adminJadwalUpdate();    break;
    case 'admin-jadwal-delete':   $controller->adminJadwalDelete();    break;

    case 'admin-post':            $controller->adminPost();            break;
    case 'admin-post-create':     $controller->adminPostCreate();      break;
    case 'admin-post-store':      $controller->adminPostStore();       break;
    case 'admin-post-edit':       $controller->adminPostEdit();        break;
    case 'admin-post-update':     $controller->adminPostUpdate();      break;
    case 'admin-post-delete':     $controller->adminPostDelete();      break;

    default: $controller->index(); break;
}