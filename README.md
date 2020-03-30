Install

Dependencies 

Back end
```
composer require doctrine/dbal

```

Front end

Habilitando a execução de scripts PowerShell se precisar

Por padrão, até mesmo devido a uma questão de segurança, a possibilidade de execução de scripts Power Shell vem desabilitada no sistema. Para habilitar essa característica precisamos mudar a politica de execução da seguinte forma.

Execute o Power Shell e digite no terminal o seguinte comando:

```

Get-ExecutionPolicy
```
O retorno deverá ser Restricted

Para permitir a execução de scripts sem qualquer restrição, vamos utilizar a regra Unrestricted, que permite executar todo e qualquer script PowerShell para isso, digite o comando abaixo:

```
Set-ExecutionPolicy Unrestricted
```
Será exibida uma mensagem informando sobre a proteção quanto à execução de Scripts. Digite “S” e pressione Enter. Conforme a imagem abaixo.

Agora digite novamente:
 ```
 Get-ExecutionPolicy 
```
E o retorno será Unrestricted, ou seja, scripts PowerShell já podem ser executados de forma irrestrita nesta máquina.
