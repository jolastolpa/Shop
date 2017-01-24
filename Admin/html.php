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

function displayOrders() { 
            echo '<table class="table table-striped">'; 
            echo '<tr><th> Id </th><th> Id użytkownika </th><th> Status </th><th>'
            . 'Data powstania</th> <th> Edytuj </th><th> Usuń </th><th>' ; 
} 

