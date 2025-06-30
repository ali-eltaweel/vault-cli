<?php

namespace Vault\CLI;

use App\CLI\CliApplication;

use CommandParser\Command;
use CommandParser\Option;
use CommandParser\Specs\Command as CommandSpecs;

use RuntimeException;
use Vault\IV\IV;
use Vault\IV\IVFile;
use Vault\Vault\Vault;

final class App extends CliApplication {

    /**
     * Main application loop.
     * 
     * @final
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return never
     */
    protected final function loop(): void {

        if (empty($this->commandline->subCommands)) {

            throw new RuntimeException('vault: No operation specified.');
        }

        /**
         * @var Command $command
         */
        $subCommand = $this->commandline->subCommands[0];

        match ($subCommand->name) {

            'init'   => $this->initializeVault($subCommand),
            'get'    => $this->getValueFromVault($subCommand),
            'set'    => $this->setValueToVault($subCommand),
            'remove' => $this->removeValueFromVault($subCommand),
        };
        
        exit(0);
    }

    private function initializeVault(Command $command): void {

        $vaultFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'vaultFilename'
        ))[0]->values[0];

        $ivFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'ivFilename'
        ))[0]->values[0];

        $algorithm = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'algorithm'
        ))[0]->values[0];

        $passphraseOption = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'passphrase'
        ))[0] ?? null;

        if (!is_null($passphraseOption)) {

            fwrite(STDERR, "Warning: Specifying passphrase on the command line is not secure.\n");
        }

        if (file_exists($vaultFilename)) {
            
            throw new RuntimeException("Vault file '$vaultFilename' already exists.");
        }

        if (file_exists($ivFilename)) {
            
            throw new RuntimeException("IV file '$ivFilename' already exists.");
        }

        $passphrase = $passphraseOption?->values[0] ?? $this->getPassphrase(confirm: true);
        $ivFile     = new IVFile($ivFilename);

        $ivFile->data = IV::forMethod($algorithm);

        $vault = new Vault(iv: $ivFile->data, passphrase: $passphrase, filename: $vaultFilename);
        
        $vault->get(''); // do any operation to initialize the vault

        echo "Vault initialized successfully.\n";
    }

    private function getValueFromVault(Command $command): void {

        $vaultFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'vaultFilename'
        ))[0]->values[0];

        $ivFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'ivFilename'
        ))[0]->values[0];

        $passphraseOption = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'passphrase'
        ))[0] ?? null;

        if (!is_null($passphraseOption)) {

            fwrite(STDERR, "Warning: Specifying passphrase on the command line is not secure.\n");
        }

        if (!file_exists($vaultFilename)) {

            throw new RuntimeException("Vault file '$vaultFilename' does not exist.");
        }

        if (!file_exists($ivFilename)) {

            throw new RuntimeException("IV file '$ivFilename' does not exist.");
        }

        $passphrase = $passphraseOption?->values[0] ?? $this->getPassphrase(confirm: false);

        $ivFile     = new IVFile($ivFilename);
        $vault      = new Vault(iv: $ivFile->data, passphrase: $passphrase, filename: $vaultFilename);
        
        echo json_encode(array_combine(
            $command->operands[0]->value,
            array_map($vault->get(...), $command->operands[0]->value)
        ), JSON_PRETTY_PRINT) . PHP_EOL;
    }

    private function setValueToVault(Command $command): void {

        $vaultFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'vaultFilename'
        ))[0]->values[0];

        $ivFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'ivFilename'
        ))[0]->values[0];

        $passphraseOption = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'passphrase'
        ))[0] ?? null;

        if (!is_null($passphraseOption)) {

            fwrite(STDERR, "Warning: Specifying passphrase on the command line is not secure.\n");
        }

        if (!file_exists($vaultFilename)) {

            throw new RuntimeException("Vault file '$vaultFilename' does not exist.");
        }

        if (!file_exists($ivFilename)) {

            throw new RuntimeException("IV file '$ivFilename' does not exist.");
        }

        $passphrase = $passphraseOption?->values[0] ?? $this->getPassphrase(confirm: false);

        $ivFile     = new IVFile($ivFilename);
        $vault      = new Vault(iv: $ivFile->data, passphrase: $passphrase, filename: $vaultFilename);

        $vault->set($command->operands[0]->value, $command->operands[1]->value);
    }

    private function removeValueFromVault(Command $command): void {

        $vaultFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'vaultFilename'
        ))[0]->values[0];

        $ivFilename = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'ivFilename'
        ))[0]->values[0];

        $passphraseOption = array_values(array_filter(
            $command->options,
            fn (Option $option): bool => $option->name === 'passphrase'
        ))[0] ?? null;

        if (!is_null($passphraseOption)) {

            fwrite(STDERR, "Warning: Specifying passphrase on the command line is not secure.\n");
        }

        if (!file_exists($vaultFilename)) {

            throw new RuntimeException("Vault file '$vaultFilename' does not exist.");
        }

        if (!file_exists($ivFilename)) {

            throw new RuntimeException("IV file '$ivFilename' does not exist.");
        }

        $passphrase = $passphraseOption?->values[0] ?? $this->getPassphrase(confirm: false);

        $ivFile     = new IVFile($ivFilename);
        $vault      = new Vault(iv: $ivFile->data, passphrase: $passphrase, filename: $vaultFilename);
        
        foreach ($command->operands[0]->value as $key) {

            $vault->remove($key);
        }
    }

    private function getPassphrase(bool $confirm): string {

        echo "Enter passphrase: ";
        system('stty -echo');
        $passphrase = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";

        if (!$confirm) {
            
            return $passphrase;
        }

        echo "Re-enter passphrase: ";
        system('stty -echo');
        $rePassphrase = trim(fgets(STDIN));
        system('stty echo');
        echo "\n";
        
        if ($passphrase !== $rePassphrase) {

            throw new RuntimeException('Passphrases do not match. Please try again.');
        }

        return $passphrase;
    }

    /**
     * Retrieves the command specifications for the application.
     * 
     * @final
     * @static
     * @internal
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @return CommandSpecs
     */
    protected static final function getCommandSpecs(): CommandSpecs {

        return require '/usr/local/lib/vault/include/command-specs.php';
    }
}
