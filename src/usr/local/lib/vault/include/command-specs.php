<?php

use CommandParser\Specs\Command;
use CommandParser\Specs\Operand;
use CommandParser\Specs\Option;
use CommandParser\Specs\OptionToken;
use CommandParser\Specs\OptionTokenType;

return new command(
    name: 'vault',
    description: 'Vault CLI application',
    subCommands: [
        new Command(
            name: 'init',
            description: 'Initialize a new vault',
            options: [
                new Option(
                    name: 'vaultFilename',
                    description: 'The filename of the vault to initialize',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'vault-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'ivFilename',
                    description: 'The filename of the initialization vector file',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'iv-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'algorithm',
                    description: 'The encryption algorithm',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'algorithm', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'passphrase',
                    description: 'The encryption passphrase',
                    tokens: [
                        new OptionToken(token: 'passphrase', type: OptionTokenType::Extended)
                    ]
                )
            ]
        ),
        new Command(
            name: 'get',
            description: 'Retrieves a value from the vault',
            options: [
                new Option(
                    name: 'vaultFilename',
                    description: 'The filename of the vault to read from',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'vault-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'ivFilename',
                    description: 'The filename of the initialization vector file',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'iv-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'passphrase',
                    description: 'The encryption passphrase',
                    tokens: [
                        new OptionToken(token: 'passphrase', type: OptionTokenType::Extended)
                    ]
                )
            ],
            operands: [
                new Operand(
                    index: 0,
                    name: 'keys',
                    description: 'The keys to retrieve from the vault',
                    isRequired: true,
                    isVariadic: true
                )
            ]
        ),
        new Command(
            name: 'set',
            description: 'Updates a value from the vault',
            options: [
                new Option(
                    name: 'vaultFilename',
                    description: 'The filename of the vault to read from',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'vault-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'ivFilename',
                    description: 'The filename of the initialization vector file',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'iv-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'passphrase',
                    description: 'The encryption passphrase',
                    tokens: [
                        new OptionToken(token: 'passphrase', type: OptionTokenType::Extended)
                    ]
                )
            ],
            operands: [
                new Operand(
                    index: 0,
                    name: 'key',
                    description: 'The key to update in the vault',
                    isRequired: true
                ),
                new Operand(
                    index: 1,
                    name: 'value',
                    description: 'The value to update in the vault',
                    isRequired: true
                )
            ]
        ),
        new Command(
            name: 'remove',
            description: 'Removes value(s) from the vault',
            options: [
                new Option(
                    name: 'vaultFilename',
                    description: 'The filename of the vault to remove from',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'vault-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'ivFilename',
                    description: 'The filename of the initialization vector file',
                    isRequired: true,
                    tokens: [
                        new OptionToken(token: 'iv-file', type: OptionTokenType::Extended)
                    ]
                ),
                new Option(
                    name: 'passphrase',
                    description: 'The encryption passphrase',
                    tokens: [
                        new OptionToken(token: 'passphrase', type: OptionTokenType::Extended)
                    ]
                )
            ],
            operands: [
                new Operand(
                    index: 0,
                    name: 'keys',
                    description: 'The key(s) to remove from the vault',
                    isRequired: true,
                    isVariadic: true
                )
            ]
        )
    ]
);
