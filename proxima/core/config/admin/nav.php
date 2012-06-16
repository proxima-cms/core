<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Auto generated on: Thursday 14th of June 2012 06:03:16 PM
 * Notes: Change the default admin navigation links in config/admin/default.php
 */

return array (
  'links' => 
  array (
    'admin' => 
    array (
      'text' => 'Dashboard',
    ),
    '#nav-content' => 
    array (
      'text' => 'Content',
      'groups' => 
      array (
        'pages' => 
        array (
          'admin/pages' => 
          array (
            'text' => 'Manage pages',
          ),
          'admin/pages/add' => 
          array (
            'text' => 'Add page',
          ),
        ),
        'tags' => 
        array (
          'admin/tags' => 
          array (
            'text' => 'Manage tags',
          ),
          'admin/tags/add' => 
          array (
            'text' => 'Add tag',
          ),
        ),
      ),
    ),
    '#nav-users' => 
    array (
      'text' => 'Users',
      'groups' => 
      array (
        'users' => 
        array (
          'admin/users' => 
          array (
            'text' => 'Manage users',
          ),
          'admin/users/add' => 
          array (
            'text' => 'Add user',
          ),
        ),
        'groups' => 
        array (
          'admin/groups' => 
          array (
            'text' => 'Manage groups',
          ),
          'admin/groups/add' => 
          array (
            'text' => 'Add group',
          ),
        ),
        'roles' => 
        array (
          'admin/roles' => 
          array (
            'text' => 'Manage roles',
          ),
          'admin/roles/add' => 
          array (
            'text' => 'Add role',
          ),
        ),
      ),
    ),
    '#nav-assets' => 
    array (
      'text' => 'Assets',
      'pages' => 
      array (
        'admin/assets' => 
        array (
          'text' => 'Manage assets',
        ),
        'admin/assets/upload' => 
        array (
          'text' => 'Upload assets',
        ),
      ),
    ),
    'admin/config' => 
    array (
      'text' => 'Config',
    ),
    '#nav-modules' => 
    array (
      'text' => 'Modules',
      'pages' => 
      array (
        'admin/modules' => 
        array (
          'text' => 'Manage modules',
        ),
        'admin/modules/add' => 
        array (
          'text' => 'Add module',
        ),
      ),
      'groups' => 
      array (
        'Addon modules' => 
        array (
          'admin/blogimport' => 
          array (
            'text' => 'Blog import',
          ),
        ),
      ),
    ),
  ),
);