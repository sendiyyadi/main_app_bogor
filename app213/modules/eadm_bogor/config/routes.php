<?php  if ( ! defined("BASEPATH")) exit("No direct script access allowed");
$modul = "retribusi";

$route["{$modul}/about"] = "eon_beji"; //sample aja; langsung nama controller di dalam module-nya

// urutan/order ngaruh cui
$route["{$modul}/skpd/proses_sk/(:any)"]  = "sptpd/edit/$1";
$route["{$modul}/skpd/(:any)"] = "sptpd/$1";
$route["{$modul}/skpd"] = "sptpd"; 
