<?php

namespace Tests\Unit;

use DocsBrasil\Domain\Documents\Cnpj\Cnpj;

it('validates CNPJ', function () {
    $validCnpj = '19.228.187/0001-03';
    $invalidCnpj = '11.111.111/1111-11';

    expect(Cnpj::init($validCnpj)->validate())->toBeTrue();
    expect(Cnpj::init($invalidCnpj)->validate())->toBeFalse();
});

it('adds mask to CNPJ', function () {
    $cnpj = '19228187000103';
    $maskedCnpj = '19.228.187/0001-03';

    expect(Cnpj::init($cnpj)->addMask())->toBe($maskedCnpj);
});
