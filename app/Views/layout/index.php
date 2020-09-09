<?php
echo view('layout/header');
echo view('layout/sidebar');
$this->renderSection('content');
echo view('layout/footer');
?>