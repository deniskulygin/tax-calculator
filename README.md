# Project

Different countries have different taxes applied when people purchase goods. Some countries have **Value Added Tax (VAT)**, other countries have **Goods and Services Tax (GST)**, while Canada has **Harmonized Sales Tax (HST)** and so on.

In some countries/states, we might have several taxes applicable to the purchase.

**So the goal is to have a microservice that will return all relevant taxes suitable for the provided location in a normalized fashion.**

# Request structure
```
http://localhost:{port}/api/v1/taxes?country=COUNTRY_CODE&state=FULL_STATE_NAME
```
`Note:` state name is case-insensitive

# Request scenarios


| Country   | State      | Taxes                     |
|-----------|------------|---------------------------|
| CA        | Quebec     | GST/HST: 5% , PST: 9.975% |
 | CA        | Ontario    | GST/HST: 13%              |
| US        | California | VAT: 7.25%                |
| LT        |            | VAT: 21%                  |
| LV        |            | VAT: 21%                  |
| EE        |            | VAT: 20%                  |
| PL        |            | Error: could not retrieve |
| DE        |            | VAT: 19%                  |


# Project commands

Setup project:
```bash
make setup
```

Run project:
```bash
make start
```

Stop project:
```bash
make stop
```

Enter project app container with `bash`:
```bash
make stop
```

Run integration tests environment:
```bash
make integration-test-up
```

Stop integration tests environment:
```bash
make integration-test-down
```

Run integration tests:
```bash
make integration-test-run
```

Run integration tests:
```bash
make integration-test-run
```

Enter project integration tests with `bash`:
```bash
make integration-test-bash
```

Run unit tests:
```bash
make unit-test-run
```

Check the code for standard violations:
```bash
make phpcs
```

Automatically fix code according to the defined standards:
```bash
make phpcbf
```
