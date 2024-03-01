# Documentação das Classes CPF, CNPJ e CPF/CNPJ

Este arquivo contém a documentação das classes PHP relacionadas a CPF, CNPJ e CPF/CNPJ.

## Instalação
### via Composer

```shell
$\> composer require arielfelippi/docs-brasil
```

## Classes

### `Cpf`

A classe `Cpf` é responsável por manipular e validar números de CPF.

#### Exemplo de Uso

```php
use DocsBrasil\Cpf;

// Exemplo com CPF sem máscara
$cpf = Cpf::init('12345678909');
echo $cpf->addMask(); // Saída: 123.456.789-09
echo $cpf->validate() ? 'CPF válido' : 'CPF inválido'; // Saída: CPF válido

// Exemplo com CPF com máscara
$cpfComMascara = Cpf::init('123.456.789-09');
echo $cpfComMascara->addMask(); // Saída: 123.456.789-09
echo $cpfComMascara->validate() ? 'CPF válido' : 'CPF inválido'; // Saída: CPF válido
```

### `Cnpj`

A classe `Cnpj` é responsável por manipular e validar números de CNPJ.

#### Exemplo de Uso

```php

use DocsBrasil\Cnpj;

// Exemplo com CNPJ sem máscara
$cnpj = Cnpj::init('12345678000199');
echo $cnpj->addMask(); // Saída: 12.345.678/0001-99
echo $cnpj->validate() ? 'CNPJ válido' : 'CNPJ inválido'; // Saída: CNPJ válido

// Exemplo com CNPJ com máscara
$cnpjComMascara = Cnpj::init('12.345.678/0001-99');
echo $cnpjComMascara->addMask(); // Saída: 12.345.678/0001-99
echo $cnpjComMascara->validate() ? 'CNPJ válido' : 'CNPJ inválido'; // Saída: CNPJ válido
```

### `CpfCnpj`

A classe `CpfCnpj` é responsável por manipular e validar números de CPF ou CNPJ independente do valor de entrada.

#### Exemplo de Uso

```php

use DocsBrasil\CpfCnpj;

// Exemplo com CPF
$cpfCnpj = CpfCnpj::init('12345678909');
echo $cpfCnpj->addMask(); // Saída: 123.456.789-09
echo $cpfCnpj->validate() ? 'CPF válido' : 'CPF inválido'; // Saída: CPF válido

// Exemplo com CNPJ
$cpfCnpj = CpfCnpj::init('12345678000199');
echo $cpfCnpj->addMask(); // Saída: 12.345.678/0001-99
echo $cpfCnpj->validate() ? 'CNPJ válido' : 'CNPJ inválido'; // Saída: CNPJ válido

// Exemplo com CPF com máscara
$cpfCnpjComMascara = CpfCnpj::init('123.456.789-09');
echo $cpfCnpjComMascara->addMask(); // Saída: 123.456.789-09
echo $cpfCnpjComMascara->validate() ? 'CPF válido' : 'CPF inválido'; // Saída: CPF válido

// Exemplo com CNPJ com máscara
$cpfCnpjComMascara = CpfCnpj::init('12.345.678/0001-99');
echo $cpfCnpjComMascara->addMask(); // Saída: 12.345.678/0001-99
echo $cpfCnpjComMascara->validate() ? 'CNPJ válido' : 'CNPJ inválido'; // Saída: CNPJ válido
```
