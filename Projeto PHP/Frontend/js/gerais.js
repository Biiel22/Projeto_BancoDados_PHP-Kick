const HOST = "https://bare-subsystem.000webhostapp.com/api";

function pegarUsuarioLogado() {
    return ({email: localStorage.getItem("email"), senha: localStorage.getItem("senha"), idUsuario: localStorage.getItem("idUsuario")});
}

function cadastrarUsuarioLogadoSessao(email, senha, idUsuario) {
    localStorage.setItem("email", email);
    localStorage.setItem("senha", senha);
    localStorage.setItem("idUsuario", idUsuario);
}

function removerUsuarioLogadoSessao() {
    localStorage.removeItem("email");
    localStorage.removeItem("senha");
    localStorage.removeItem("idUsuario");
}

async function verificarLogin() {
    const usuarioLogado = pegarUsuarioLogado();
    if(usuarioLogado.email == null || usuarioLogado.senha == null || usuarioLogado.idUsuario == null) {
        window.location.href = "./index.html";
    } else {
        const respUsuarios = await dadosUsuarioEmailSenha(usuarioLogado.email, usuarioLogado.senha)
        if(respUsuarios["resultados"].length > 0) {
            return true;
        } else {
            window.location.href = "./index.html";
        }
    }
}

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