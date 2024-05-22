<p>
    {$To},
    <br />
</p>

<p>
    Um novo usuário registou-se com as seguintes informações:
    <br />
    E-mail: {$EmailAddress}
    <br />
    Nome: {$FullName}
    <br />
    Telefone: {$Phone}
    <br />
    Organização: {$Organization}
    <br />
    Posição: {$Position}
    {if !empty($CreatedBy)}
        <br />
        Criada por: {$CreatedBy}
    {/if}
</p>
