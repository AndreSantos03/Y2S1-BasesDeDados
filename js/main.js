const list = document.getElementById("ticket_list");
const pagination = document.getElementById("pagination");
let active_remove = document.getElementById("active_remove");
let closed_remove = document.getElementById("closed_remove");
let active = document.getElementById("active");
let closed = document.getElementById("closed");
let activeBtn = document.getElementById("activeBtn");
let closedBtn = document.getElementById("closedBtn");
let recentBtn = document.getElementById("recentBtn");
let oldestBtn = document.getElementById("oldestBtn");
let recent = document.getElementById("recent");
let oldest = document.getElementById("oldest");

let current_page = 1;

let rows = 5;

let filtersButton = document.getElementById("filtersButton");
let dropdown = document.getElementById("filters_menu");
dropdown.style.display = "none";

function DisplayList(items, wrapper, rows_per_page, page) {
    wrapper.innerHTML = "";
    page--;

    let start = rows_per_page * page;
    let end = start + rows_per_page;
    let paginatedItems = items.slice(start, end);

    for (let i = 0; i < paginatedItems.length; i++) {
        let item = paginatedItems[i];
        wrapper.appendChild(item);
    }
}

function SetupPagination(items, wrapper, rows_per_page) {
    wrapper.innerHTML = "";

    let page_count = Math.ceil(items.length / rows_per_page);
    for (let i = 1; i < page_count + 1; i++) {
        let btn = PaginationButton(i, items);
        wrapper.appendChild(btn);
    }
}

function PaginationButton(page, items) {
    let button = document.createElement('button');
    button.innerText = page;

    if (current_page == page) button.classList.add('active');

    button.addEventListener('click', function () {
        current_page = page;
        DisplayList(items, list, rows, current_page);

        let current_btn = document.querySelector('.pagenumbers button.active');
        current_btn.classList.remove('active');

        button.classList.add('active');
    });

    return button;
}

async function GetTickets() {

    const active = !activeBtn.classList.contains("filters_button_active");
    const closed = !closedBtn.classList.contains("filters_button_active");
    const recent = !recentBtn.classList.contains("filters_button_active");

    const url = `../api/ticket.api.php?active=${active}&closed=${closed}&recent=${recent}`;
    const response = await fetch(url);
    return await response.json();
}


function drawTicket(ticket) {
    const ticketElement = document.createElement("div");
    ticketElement.classList.add("ticket");

    const ticketStatusSpacer = document.createElement("div");
    ticketStatusSpacer.classList.add("ticket_status_spacer");

    const ticketStatus = document.createElement("div");
    ticketStatus.classList.add("ticket_status");

    const ticketStatusText = document.createElement("p");
    ticketStatusText.textContent = ticket["status"];

    ticketStatus.appendChild(ticketStatusText);
    ticketStatusSpacer.appendChild(ticketStatus);
    ticketElement.appendChild(ticketStatusSpacer);

    const ticketContent = document.createElement("div");
    ticketContent.classList.add("ticket_content");

    const ticketTitle = document.createElement("div");
    ticketTitle.classList.add("ticket_title");

    const ticketTitleIcon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    ticketTitleIcon.setAttribute("xmlns", "http://www.w3.org/2000/svg");
    ticketTitleIcon.setAttribute("viewBox", "0 0 20 20");
    ticketTitleIcon.setAttribute("fill", "currentColor");
    ticketTitleIcon.classList.add("w-5", "h-5");

    const ticketTitlePath = document.createElementNS("http://www.w3.org/2000/svg", "path");
    ticketTitlePath.setAttribute("fill-rule", "evenodd");
    ticketTitlePath.setAttribute("d", "M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z");
    ticketTitlePath.setAttribute("clip-rule", "evenodd");

    ticketTitleIcon.appendChild(ticketTitlePath);
    ticketTitle.appendChild(ticketTitleIcon);

    const ticketTitleText = document.createElement("p");
    ticketTitleText.textContent = ticket.title;

    ticketTitle.appendChild(ticketTitleText);
    ticketContent.appendChild(ticketTitle);

    const ticketDesc = document.createElement("div");
    ticketDesc.classList.add("ticket_desc");

    const ticketDescText = document.createElement("p");
    ticketDescText.textContent = ticket.desc + "...";

    ticketDesc.appendChild(ticketDescText);
    ticketContent.appendChild(ticketDesc);
    ticketElement.appendChild(ticketContent);

    const ticketInfo = document.createElement("div");
    ticketInfo.classList.add("ticket_info");

    const ticketInfoText = document.createElement("p");
    ticketInfoText.textContent = ticket.datetime;

    ticketInfo.appendChild(ticketInfoText);
    ticketElement.appendChild(ticketInfo);

    return ticketElement;
}
async function drawTickets() {
    const tickets = await GetTickets();
    let items = [];

    for (let i = 0; i < tickets.length; i++) {
        const ticket = tickets[i];
        const ticketElement = drawTicket(ticket);
        items.push(ticketElement);
    }
    DisplayList(items, list, rows, current_page);
    SetupPagination(items, pagination, rows);

}

drawTickets();

// Adiciona o evento de clique ao botão
filtersButton.addEventListener("click", function () {
    // Verifica o estado atual do dropdown
    if (dropdown.style.display === "none") {
        // Se estiver oculto, mostra o dropdown com "display: flex"
        dropdown.style.display = "flex";
    } else {
        // Se estiver visível, oculta o dropdown
        dropdown.style.display = "none";
    }
});

active_remove.addEventListener("click", function () {
    active.style.visibility = "hidden";
    activeBtn.classList.remove("filters_button_active");
    activeBtn.classList.add("filters_button_inactive");
    drawTickets();
});

closed_remove.addEventListener("click", function () {
    closed.style.visibility = "hidden";
    closedBtn.classList.remove("filters_button_active");
    closedBtn.classList.add("filters_button_inactive");
    drawTickets();
});


activeBtn.addEventListener("click", function () {
    if (active.style.visibility === "hidden") {
        active.style.visibility = "visible";
        activeBtn.classList.remove("filters_button_inactive");
        activeBtn.classList.add("filters_button_active");
        drawTickets();
    } else {
        active.style.visibility = "hidden";
        activeBtn.classList.remove("filters_button_active");
        activeBtn.classList.add("filters_button_inactive");
        drawTickets();
    }
});

closedBtn.addEventListener("click", function () {
    if (closed.style.visibility === "hidden") {
        closed.style.visibility = "visible";
        closedBtn.classList.remove("filters_button_inactive");
        closedBtn.classList.add("filters_button_active");
        drawTickets();
    } else {
        closed.style.visibility = "hidden";
        closedBtn.classList.remove("filters_button_active");
        closedBtn.classList.add("filters_button_inactive");
        drawTickets();
    }
});

recentBtn.addEventListener("click", function () {
    oldest.style.display = "none";
    recent.style.display = "flex";
    recentBtn.style.display = "none";
    recentBtn.classList.remove("filters_button_active");
    recentBtn.classList.add("filters_button_inactive");
    oldestBtn.classList.remove("filters_button_inactive");
    oldestBtn.classList.add("filters_button_active");
    oldestBtn.style.display = "flex";
    drawTickets();
});

oldestBtn.addEventListener("click", function () {
    recent.style.display = "none";
    oldest.style.display = "flex";
    oldestBtn.style.display = "none";
    oldestBtn.classList.remove("filters_button_active");
    oldestBtn.classList.add("filters_button_inactive");
    recentBtn.classList.remove("filters_button_inactive");
    recentBtn.classList.add("filters_button_active");
    recentBtn.style.display = "flex";
    drawTickets();
});