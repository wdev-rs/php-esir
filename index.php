<?php 
require_once('vendor/autoload.php');
use WdevRs\PhpEsir\Invoice\Invoice;
use WdevRs\PhpEsir\Request\Request;



$invoiceJsonString = '{
    "requestedBy": "4Z9V79X6",
    "sdcDateTime": "2022-01-15T10:42:02.9770000",
    "invoiceCounter": "3/97ПР",
    "invoiceCounterExtension": "ПР",
    "invoiceNumber": "4Z9V79X6-4Z9V79X6-97",
    "taxItems": [
      {
        "categoryType": 0,
        "label": "A",
        "amount": 19.0115,
        "rate": 9.0,
        "categoryName": "VAT"
      },
      {
        "categoryType": 0,
        "label": "B",
        "amount": 0.0,
        "rate": 0.0,
        "categoryName": "VAT"
      },
      {
        "categoryType": 0,
        "label": "F",
        "amount": 2.5766,
        "rate": 11.0,
        "categoryName": "ECAL"
      }
    ],
    "verificationUrl": "https://sandbox.suf.purs.gov.rs/v/?vl=AzRaOVY3OVg2NFo5Vjc5WDZhAAAAAwAAAMQZJwAAAAAAAAABfl1UdGEAAQYxMDA1Mjao3FSDX4C0NtzgaO7PyBa5b9XoikzHKsBGLsh9k%2FdGt82hR8i6lxmOcflZPA%2B51Wlql9GaEFo0ryn1PTeUJcUa8caj0tGJ2VWXZY4k5MvnA3YVKddStMfBPkNcF6pNr34Bz%2FpPx%2BHBeH3lyIc9hgLIO9qPA1Pc%2B5re4bMXaMeFaAWxQn1P%2BaZ7uATR%2Fh00LT6hjIPM4PB7RWzLF7tFBWKYANnkfPZIiqz%2Btahbnj0tj5fy8DEW5kSMFsVdaxw3S3KiTEQKnSpOrRFV1KfZNPtXOWmfhb9Sz%2FDnX27veQpJczZJpN0wToAv4T%2FfqxCvbHLkCJDCKjArXHCCY9ACrPHoWN0Zv6I2S3V0v3nnydJUC2FHkQhR1ANoK59P0Jgc3gDnb7JCjlhSH2aAguzhkqGSp6%2BLhVxnxZ0BOXiomzPn6UAF%2FZH4%2BULaIZhjZAJtIapk2SK8QYhcVdVfOmSGT2aXV5VJBWjw%2BS4gTaM1boGHL78ZsOjff6Pejkv6fjK7PdgrdDOLTb%2BZzOaOOGbrfwYHaTQdRfX6jnEwr%2B%2BJvDRAkcKZt8CPiU%2BNGNPlNbQArPioXkjcf%2FX4Hx0PwxEkU5ufCIb%2Frba3p%2F72STjSfKa8kBgkiID5M0MPABQmguAqHaUf9on9%2B8T0ST9RvCaDKo%2FMDvEgY7atB1L5WOZW6avTOWfDrU7Iy%2B3B11rZNpAsJoQ%3D",
    "verificationQRCode": null,
    "journal": "\r\n============ ФИСКАЛНИ РАЧУН ============\r\n\r\nПИБ:                          \u0000100839528\r\nПредузеће:        \u0000INFODATA DOO SUBOTICA\r\nМесто продаје:    \u0000INFODATA DOO SUBOTICA\r\nАдреса:           \u0000Svetozara Miletića 48\r\nОпштина:                       \u0000Суботица\r\nКасир:                           \u0000Valaki\r\nИд купца:                    \u000010: 100526\r\nОпционо поље купца:          \u000022: 145-21\r\nЕСИР број:                        \u000013-21\r\nЕСИР време:         \u000015/01/2022 11:41:55\r\nРеф. број:        \u0000DSQZUPS6-DSQZUPS6-256\r\nРеф. ДТ:            \u000016/12/2021 14:32:26\r\n\r\n-------- ПРОМЕТ РЕФУНДАЦИЈА --------\r\n\r\nАРТИКЛИ\r\n========================================\r\nНАЗИВ          ЦЕНА      КОЛ      УКУПНО\r\nTes                                     \r\nt art / kom (A)230,25    1,00     230,25\r\nkik                                     \r\niriki / kg (BF)104,00    0,25      26,00\r\n----------------------------------------\r\nУкупно рефундација:             \u0000-256,25\r\nГотовина:                       \u0000-156,25\r\n=======================================\r\nОзнака         Име       Стопа     Порез\r\nA              VAT       9,00%    -19,01\r\nB              VAT       0,00%     -0,00\r\nF              ECAL      11,00%    -2,58\r\n----------------------------------------\r\nУкупно порез:                    \u0000-21,59\r\n=======================================\r\nПФР време:          \u000015/01/2022 10:42:02\r\nПФР бр рачун:      \u00004Z9V79X6-4Z9V79X6-97\r\nБројач рачуна:                   \u00003/97ПР\r\n=======================================\r\n\r\n======== КРАЈ ФИСКАЛНОГ РАЧУНА ========",
    "messages": "Success",
    "signedBy": "4Z9V79X6",
    "encryptedInternalData": "qNxUg1+AtDbc4Gjuz8gWuW/V6IpMxyrARi7IfZP3RrfNoUfIupcZjnH5WTwPudVpapfRmhBaNK8p9T03lCXFGvHGo9LRidlVl2WOJOTL5wN2FSnXUrTHwT5DXBeqTa9+Ac/6T8fhwXh95ciHPYYCyDvajwNT3Pua3uGzF2jHhWgFsUJ9T/mme7gE0f4dNC0+oYyDzODwe0Vsyxe7RQVimADZ5Hz2SIqs/rWoW549LY+X8vAxFuZEjBbFXWscN0tyokxECp0qTq0RVdSn2TT7Vzlpn4W/Us/w519u73kKSXM2SaTdME6AL+E/36sQr2xy5AiQwiowK1xwgmPQAqzx6A==",
    "signature": "WN0Zv6I2S3V0v3nnydJUC2FHkQhR1ANoK59P0Jgc3gDnb7JCjlhSH2aAguzhkqGSp6+LhVxnxZ0BOXiomzPn6UAF/ZH4+ULaIZhjZAJtIapk2SK8QYhcVdVfOmSGT2aXV5VJBWjw+S4gTaM1boGHL78ZsOjff6Pejkv6fjK7PdgrdDOLTb+ZzOaOOGbrfwYHaTQdRfX6jnEwr++JvDRAkcKZt8CPiU+NGNPlNbQArPioXkjcf/X4Hx0PwxEkU5ufCIb/rba3p/72STjSfKa8kBgkiID5M0MPABQmguAqHaUf9on9+8T0ST9RvCaDKo/MDvEgY7atB1L5WOZW6avTOQ==",
    "totalCounter": 97,
    "transactionTypeCounter": 3,
    "totalAmount": 256.25,
    "taxGroupRevision": 2,
    "businessName": "INFODATA DOO SUBOTICA",
    "tin": "100839528",
    "locationName": "INFODATA DOO SUBOTICA",
    "address": "Svetozara Miletića 48",
    "district": "Суботица",
    "mrc": "00-0000-ID100839528RSLPV100"
  }';
$invoiceArray = json_decode($invoiceJsonString, true);
$invoice = new Invoice($invoiceArray);
//var_dump($invoice);
$reqData = array('invoiceType' =>  0,
'transactionType' =>  0,
'invoiceNumber' => '123/1.0.0',
'cashier' => 'Radnik',
'buyerId' => null,
'buyerCostCenterId' => null,
'referentDocumentNumber' => null,
'referentDocumentDT' => null,
'payment' => [

  [
    'amount' => 10,
    'paymentType' => 1
  ],
  [
    'amount' => 10,
    'paymentType' => 1
  ]
],     
'items' => [
  [
   'gtin' => '12345678',
   'name' => 'Test item/kg',
   'quantity' => 1,
   'unitPrice' => 10,
   'labels' => ['A']
  ],
  [
    'gtin' => '12345678',
    'name' => 'Test item/kg',
    'quantity' => 1,
    'unitPrice' => 10,
    'labels' => ['A']
   ]
]);
$req = new Request($reqData);
var_dump($req);
