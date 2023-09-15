<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de moeda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Valores Convertidos</h1>
        <?php 
            //Valor em REAL
            $real = $_REQUEST["valor"] ?? 0;

            //Cotação em dolar vinda do Banco Central
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y");
            
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio . '\'&@dataFinalCotacao=\'' .$fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dados = json_decode(file_get_contents($url), true);

            $cotacao = $dados["value"][0]["cotacaoCompra"];

            //equivalente a dólar
            $converção = $real / $cotacao;

            //Biblioteca intl (Internalization PHP)
            //Formatação de moedas com INTERNACIONALIZAÇÃO
            $padrão = numfmt_create("pt_BR", NumberFormatter::CURRENCY); //apresenta a moeda 

            echo "<p>Seus " . numfmt_format_currency($padrão, $real, "BRL") . " equivalem a <strong>" . numfmt_format_currency($padrão, $converção, "USD"). "</strong></p>";
            ?>

        <button onclick="javascript=history.go(-1)">&#x2b05; Voltar</button>
    </main>
    
</body>
</html>

