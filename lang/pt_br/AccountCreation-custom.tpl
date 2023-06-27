<p>
    {$To},
    <br />
</p>

<p>
    Um novo usuário se registrou com as seguintes informações:
    <br />
    E-mail: {$EmailAddress}
    <br />
    Nome: {$FullName}
    <br />
    Organização: {$Organization}
    {if !empty($CreatedBy)}
        <br />
        Criada por: {$CreatedBy}
    {/if}
</p>
