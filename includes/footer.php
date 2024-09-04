<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<footer>
    <p>As informações literais e gráficas apresentadas neste site sobre Yu-Gi-Oh!, incluindo imagens de cartas, atributos, símbolos de nível/classificação e tipo e texto de cartas, são protegidas por direitos autorais da 4K Media Inc, uma subsidiária da Konami Digital Entertainment, Inc. Este site não é produzido, endossado, apoiado ou afiliado à 4k Media ou à Konami Digital Entertainment.
    Todos os outros conteúdos © <span id="anoAtual"></span> Project Y</p>
    
</footer>
<script>
        let spanAnoAtual = document.getElementById("anoAtual");
        let ano = new Date().getFullYear();
        spanAnoAtual.textContent += ano;
    </script>
</body>
</html>