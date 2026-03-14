<?php

/**Algumas opções padrões para o bootstrap table para as views */

return [

    /*
    | Opção que define quais as opções por padrão os grids terão para exportar
    */
    'export-types' => "['excel','csv']",
    'show-export' => "false",
    'toggle' => "table",
    'search' => "true",
    'pagination' => "true",
    'show-columns' => "true",
    'export-data-type' => "all",
    'show-toggle' => "true",
    'show-fullscreen' => "true",
    'show-refresh' => "true",
    'sortable' => "true",
    'page-size' => 25,
    'page-list' => "[25, 50, 100, 200, All]",
    'filter-control' => "true",
    'classes' => "table table-bordered table-hover table-striped",
    'data-side-pagination' => "server"
];
