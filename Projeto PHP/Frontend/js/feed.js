window.onload = async () => {
    const HOST = "https://bare-subsystem.000webhostapp.com/api";

    verificarLogin();

    document.getElementById("fecharPopUpCriarTarefa").addEventListener("click", () => {
        document.getElementById("novaTarefa").style.display = "None";
    })
    document.getElementById("fecharPopUpEditarTarefa").addEventListener("click", () => {
        document.getElementById("editarTarefa").style.display = "None";
    })

    document.querySelector("#novaTarefa form").addEventListener("submit", async (event) => {
        event.preventDefault();
        const tarefa = document.getElementById("textotarefa").value;
        const dataTermino = document.getElementById("dataLimite").value;
        await cadastrarTarefasUsuarioAPI(tarefa, dataTermino);
        document.getElementById("novaTarefa").style.display = "None";
        mostrarTarefas()
    })

    document.querySelector("#editarTarefa form").addEventListener("submit", async (event) => {
        event.preventDefault();
        const tarefa = document.getElementById("textotarefaEditar").value;
        const dataTermino = document.getElementById("dataLimiteEditar").value;
        const idTarefa = document.getElementById("idTarefaEditar").value;
        await editarTarefasUsuarioAPI(tarefa, dataTermino, idTarefa);
        document.getElementById("editarTarefa").style.display = "None";
        mostrarTarefas()
    })
    mostrarTarefas()
}

function sair() {
    removerUsuarioLogadoSessao();
    verificarLogin();
}

async function mostrarTarefas() {
    document.querySelector("table tbody").innerHTML = "";
    const tarefasUsuario = await buscarTarefasUsuarioAPI();
    if(tarefasUsuario.status != "ERRO") {
        for (let x=0; x<tarefasUsuario["resultados"].length; x++) {
            const linha = `
            <tr ${tarefasUsuario["resultados"][x]["feito"]=="true" ? "style='background-color: #adffad'" : ""}>
                <td>${tarefasUsuario["resultados"][x]["dataCriado"]}</td>
                <td>${tarefasUsuario["resultados"][x]["tarefa"]}</td>
                <td>${tarefasUsuario["resultados"][x]["dataTermina"]}</td>
                <td>
                    <img onclick="excluirTarefa(${tarefasUsuario['resultados'][x]['id']})" src="./img/lixeira.png" alt="Excluir">
                    <img onclick="popUpEditarTarefa(${tarefasUsuario['resultados'][x]['id']})" src="./img/editar.png" alt="Editar">
                    <img onclick="alterarFeitoTarefa(${tarefasUsuario['resultados'][x]['id']})" src="./img/check.png" alt="Feito">
                </td>
            </tr>
            `;
            document.querySelector("table tbody").innerHTML += linha;
        }
    } else {
        alert("Sem afazeres cadastrados")
    }
}

async function excluirTarefa(idTarefa) {
    await excluirTarefasUsuarioAPI(idTarefa);
    mostrarTarefas();
}

async function alterarFeitoTarefa(idTarefa) {
    await editarFeitoTarefasUsuarioAPI(idTarefa);
    mostrarTarefas();
}

function popUpTarefa() {
    document.getElementById("novaTarefa").style.display = "Flex";
}
async function popUpEditarTarefa(idTarefa) {
    document.getElementById("editarTarefa").style.display = "Flex";
    const respTarefa = await buscarTarefaIdAPI(idTarefa);
    console.log(respTarefa)
    document.getElementById("textotarefaEditar").innerHTML = respTarefa["resultados"][0]["tarefa"];
    document.getElementById("dataLimiteEditar").value = respTarefa["resultados"][0]["dataTermina"];
    document.getElementById("idTarefaEditar").value = respTarefa["resultados"][0]["id"];
}

async function adicionarTarefaAPI(tarefa, dataTermina) {
    const resp = await fetch(`${HOST}/tarefa/cadastrarTarefa.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "tarefa": tarefa,
            "dataTermina": dataTermina,
            "idUsuario": pegarUsuarioLogado().idUsuario,
        })
    })
    const data = await resp.json();
    return(data);
}

async function buscarTarefasUsuarioAPI() {
    const idUsuario = pegarUsuarioLogado()["idUsuario"];
    const resp = await fetch(`${HOST}/tarefa/dadosTarefas.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "idUsuario": idUsuario,
        })
    })
    const data = await resp.json();
    return(data);
}

async function buscarTarefaIdAPI(id) {
    const resp = await fetch(`${HOST}/tarefa/dadosTarefaId.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "idTarefa": id,
        })
    })
    const data = await resp.json();
    return(data);
}

async function cadastrarTarefasUsuarioAPI(tarefa, dataTermina) {
    const idUsuario = pegarUsuarioLogado()["idUsuario"];
    const resp = await fetch(`${HOST}/tarefa/cadastrarTarefa.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "tarefa": tarefa,
            "dataTermina": dataTermina,
            "idUsuario": idUsuario,
        })
    })
    const data = await resp.json();
    return(data);
}

async function editarTarefasUsuarioAPI(tarefa, dataTermina, idTarefa) {
    const resp = await fetch(`${HOST}/tarefa/editarTarefa.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "tarefa": tarefa,
            "dataTermina": dataTermina,
            "idTarefa": idTarefa,
        })
    })
    const data = await resp.json();
    return(data);
}

async function excluirTarefasUsuarioAPI(idTarefa) {
    const resp = await fetch(`${HOST}/tarefa/deletarTarefa.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "idTarefa": idTarefa,
        })
    })
    const data = await resp.json();
    return(data);
}

async function editarFeitoTarefasUsuarioAPI(idTarefa) {
    const resp = await fetch(`${HOST}/tarefa/editarFeito.php`, {
        "method": "POST",
        headers: {
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            "idTarefa": idTarefa,
        })
    })
    const data = await resp.json();
    return(data);
}