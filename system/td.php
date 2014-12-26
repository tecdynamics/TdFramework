<?php
 

/**
  function autoload($className)
  {

  $paths = array(
  'application/controllers',
  'application/models',
  'system/',
  );
  $helpers = array_filter(glob('application/helpers/*'), 'is_dir');
  $plugins = array_filter(glob('application/plugins/*'), 'is_dir');
  $folders= @array_merge($helpers, $plugins);

  $array_edit=function($val, $key='') use (&$paths){
  foreach ($val as $key=>$vars){
  if(!empty($vars)){
  $paths[]= $vars;        }
  }
  };

  foreach ($folders as $key => $extrafile) {
  $internalfolders[] =  array_filter(glob($extrafile.'/*'), 'is_dir');
  array_filter($internalfolders);
  }

  array_walk($internalfolders,$array_edit);

  $paths = array_merge($paths, $folders);

  $filenames=array(
  '%s.php',
  '%s.class.php',
  'class.%s.php',
  '%s.inc.php',
  '%s_controller.php',
  '%s.smtp.php'
  );

  $path = str_ireplace('_', '/', strtolower($className));

  if(@include_once $path.'.php'){
  return;
  }

  foreach($paths as $dirs){
  foreach ($filenames as $filename){
  $searchedpath = $dirs . '/' . sprintf($filename, strtolower($className));

  if(file_exists($searchedpath)){
  require_once $searchedpath;
  return;
  }
  }

  }
  }

 * */
eval(base64_decode('ZnVuY3Rpb24gYXV0b2xvYWQoJGNsYXNzTmFtZSkNCnsNCgkgDQogICAgICRwYXRocyA9IGFycmF5KA0KICAgICAgICAnYXBwbGljYXRpb24vY29udHJvbGxlcnMnLCANCiAgICAgICAgJ2FwcGxpY2F0aW9uL21vZGVscycsDQogICAgICAgICdzeXN0ZW0vJywNCiAgICApOw0KICAgICRoZWxwZXJzID0gYXJyYXlfZmlsdGVyKGdsb2IoJ2FwcGxpY2F0aW9uL2hlbHBlcnMvKicpLCAnaXNfZGlyJyk7DQogICAgJHBsdWdpbnMgPSBhcnJheV9maWx0ZXIoZ2xvYignYXBwbGljYXRpb24vcGx1Z2lucy8qJyksICdpc19kaXInKTsNCiAgICAkZm9sZGVycz0gQGFycmF5X21lcmdlKCRoZWxwZXJzLCAkcGx1Z2lucyk7DQogICAgDQogICAgJGFycmF5X2VkaXQ9ZnVuY3Rpb24oJHZhbCwgJGtleT0nJykgdXNlICgmJHBhdGhzKXsgICAgICAgIA0KICAgICAgICBmb3JlYWNoICgkdmFsIGFzICRrZXk9PiR2YXJzKXsNCiAgICAgICAgICAgIGlmKCFlbXB0eSgkdmFycykpeyAgICAgICAgICAgICAgIA0KICAgICAgICAgICAkcGF0aHNbXT0gJHZhcnM7ICAgICAgICB9IA0KICAgICAgICAgICAgICAgICAgICB9ICAgICAgICANCiAgICB9OyAgICANCiAgICANCiAgICBmb3JlYWNoICgkZm9sZGVycyBhcyAka2V5ID0+ICRleHRyYWZpbGUpIHsgDQogICAgICAgICAkaW50ZXJuYWxmb2xkZXJzW10gPSAgYXJyYXlfZmlsdGVyKGdsb2IoJGV4dHJhZmlsZS4nLyonKSwgJ2lzX2RpcicpOyAgDQogICBhcnJheV9maWx0ZXIoJGludGVybmFsZm9sZGVycyk7DQogICB9ICANCg0KICAgYXJyYXlfd2FsaygkaW50ZXJuYWxmb2xkZXJzLCRhcnJheV9lZGl0KTsNCiAgIA0KICAgICAkcGF0aHMgPSBhcnJheV9tZXJnZSgkcGF0aHMsICRmb2xkZXJzKTsNCiAgICAgDQogICAgICRmaWxlbmFtZXM9YXJyYXkoDQogICAgICAgICclcy5waHAnLA0KICAgICAgICAnJXMuY2xhc3MucGhwJywNCiAgICAgICAgJ2NsYXNzLiVzLnBocCcsDQogICAgICAgICclcy5pbmMucGhwJywNCiAgICAgICAgJyVzX2NvbnRyb2xsZXIucGhwJywNCiAgICAgICAgICclcy5zbXRwLnBocCcNCiAgICApOw0KICAgICANCiAgICAkcGF0aCA9IHN0cl9pcmVwbGFjZSgnXycsICcvJywgc3RydG9sb3dlcigkY2xhc3NOYW1lKSk7DQogICAgIA0KICAgIGlmKEBpbmNsdWRlX29uY2UgJHBhdGguJy5waHAnKXsNCiAgICAgICAgIHJldHVybjsNCiAgICB9DQogICAgDQogICAgZm9yZWFjaCgkcGF0aHMgYXMgJGRpcnMpew0KICAgICAgICBmb3JlYWNoICgkZmlsZW5hbWVzIGFzICRmaWxlbmFtZSl7DQogICAgICAgICRzZWFyY2hlZHBhdGggPSAkZGlycyAuICcvJyAuIHNwcmludGYoJGZpbGVuYW1lLCBzdHJ0b2xvd2VyKCRjbGFzc05hbWUpKTsNCg0KICAgICAgICAgICAgaWYoZmlsZV9leGlzdHMoJHNlYXJjaGVkcGF0aCkpew0KICAgICAgICAgICByZXF1aXJlX29uY2UgJHNlYXJjaGVkcGF0aDsgDQogICAgICAgICAgICAgICAgcmV0dXJuOw0KICAgIH0NCiAgICB9DQogICAgICANCiAgICB9DQp9'));
spl_autoload_register('autoload');

