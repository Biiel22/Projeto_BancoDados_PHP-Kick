window.onload = () => {
    const HOST = "https://bare-subsystem.000webhostapp.com/api";

    document.querySelector("form").addEventListener("submit", async (event) => {
        event.preventDefault();
        const email = document.querySelector("input[name=i_nome]").value;
        const senha = document.querySelector("input[name=i_pass]").value;
    
        const respDadosUsuario = await dadosUsuarioEmailSenha(email, senha)
        if(respDadosUsuario["status"] == "OK") {
            cadastrarUsuarioLogadoSessao(respDadosUsuario["resultados"][0]["email"],respDadosUsuario["resultados"][0]["senha"], respDadosUsuario["resultados"][0]["id"])
            setTimeout(() => {
                window.location.href = "./feed.html";
            }, 500)
        }
    })

    async function dadosUsuarioEmailSenha(email, senha) {
        const resp = await fetch(`${HOST}/usuario/dadosUsuarioEmailSenha.php`, {
            "method": "POST",
            headers: {
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                "senha": senha,
                "email": email,
            })
        })
        const data = await resp.json();
        return(data);
    }
}