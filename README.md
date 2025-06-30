# Vault - CLI

**Secrets Repository**

- [Vault - CLI](#vault---cli)
  - [Installation](#installation)
  - [Usage](#usage)
    - [Initializing a Vault](#initializing-a-vault)
    - [Setting Key(s) into the Vault](#setting-keys-into-the-vault)
    - [Getting Key(s) from the Vault](#getting-keys-from-the-vault)
    - [Removing Key(s) from the Vault](#removing-keys-from-the-vault)

***

## Installation

Download the desired version from the releases or build it from source.

```bash
dpkg -b src dist/vault.deb
```

Install the package:

```bash
sudo dpkg -i dist/vault.deb
```

## Usage

### Initializing a Vault

```bash
vault init --vault-file=path/to/vault/file --iv-file=path/to/iv/file --algorithm=algorithm [--passphrase=passphrase]
```

### Setting Key(s) into the Vault

```bash
vault set --vault-file=path/to/vault/file --iv-file=path/to/iv/file [--passphrase=passphrase] KEY VALUE
```

### Getting Key(s) from the Vault

```bash
vault get --vault-file=path/to/vault/file --iv-file=path/to/iv/file [--passphrase=passphrase] KEY...
```

The output will be in JSON format:

```json
// vault get -- key1 key2
{
    "key1": "value1",
    "key2": "value2"
}
```

### Removing Key(s) from the Vault

```bash
vault remove --vault-file=path/to/vault/file --iv-file=path/to/iv/file [--passphrase=passphrase] KEY...
```
