<?php

function displayTitleLoadByCategory(){ 
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Nazwa </th><th> Cena </th><th> Opis </th><th> '
            . 'Ilosć dostępna </th><th>Zdjęcie</th><th> Edytuj </th><th> Usuń </th><tr>' ; 
}

function displayTitleLoadAll(){ 
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Nazwa </th><th> Cena </th><th> Opis </th><th> '
            . 'Ilosć dostępna </th><th> Kategoria </th><th>Zdjęcie</th><th> Edytuj </th><th> Usuń </th><tr>' ; 
}

function displayCategories() { 
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Nazwa </th><th> Edytuj </th><th> Usuń </th><th>' ; 
}