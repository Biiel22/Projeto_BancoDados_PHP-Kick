window.onload = () => {
    const HOST = "https://bare-subsystem.000webhostapp.com/api";

    document.querySelector("form").addEventListener("submit", async (event) => {
        event.preventDefault();
        const nome = document.querySelector("input[name=i_nome]").value;
        const email = document.querySelector("input[name=i_email]").value;
        const senha = document.querySelector("input[name=i_pass]").value;
        await adicionarUsuario(nome, email, senha);
        window.location.href = "./index.html";
    })

    async function adicionarUsuario(nome, email, senha) {
        const resp = await fetch(`${HOST}/usuario/cadastrarUsuario.php`, {
            "method": "POST",
            headers: {
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                "nome": nome,
                "email": email,
                "senha": senha,
            })
        })
        const data = await resp.json();
        return(data);
    }
}