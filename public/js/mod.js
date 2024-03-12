let labels = document.querySelectorAll("label");

labels.forEach(function (label) {
    label.addEventListener("click", function (event) {
        event.preventDefault();
    });
});

function fetchFormInfo(ticketId, formType) {
    $.ajax({
        url: "/to-formula",
        method: "get",
        data: { ticketId: ticketId, formType: formType },
        success: function (response) {
            console.log(response);
            console.log("Success");
            let textType = [];
            let numberType = [];
            let checkType = [];

            response.forEach((el) => {
                if (el.question.answer_type == "number") {
                    numberType.push(el);
                }

                if (el.question.answer_type == "text") {
                    textType.push(el);
                }

                if (el.question.answer_type == "check") {
                    checkType.push(el);
                }
            });

            console.log(numberType);

            if (numberType.length > 0) {
                let numberForm = $("#pib-pit-table-form");
                let numberTable = $('<table class="table table-bordered">');

                let th1 = $("<th>").text("Vragen");
                let th2 = $(
                    '<th style="width: 10%; word-wrap: break-word;">'
                ).text("ErnstSchaal 0-10");

                let headerRow = $("<tr>");

                headerRow.append(th1);
                headerRow.append(th2);

                numberTable.append(headerRow);

                numberForm.append(numberTable);

                numberType.forEach((el) => {
                    let tr = $("<tr>");

                    // Create and append the td elements to the tr
                    let td1 = $("<td>").text(el.question.question);
                    let td2 = $("<td >").html(
                        '<input style="width: 100%; border: none; border-bottom: 1px solid black;" type="number" name="' +
                            el.answer.id +
                            '" value="' +
                            el.answer.answer +
                            '">'
                    );
                    tr.append(td1);
                    tr.append(td2);
                    // Append the tr to the table
                    numberTable.append(tr);
                });
            }

            if (checkType.length > 0) {
                let checkForm = $("#pib-pit-table-form");
                let checkTable = $(
                    '<table class="table table-bordered"></table>'
                );

                checkForm.append(checkTable);

                checkType.forEach((el) => {
                    let tr = $("<tr>");
                    let options = el.question.options.split(/\s*,\s*/);

                    console.log(options);

                    // Create and append the td elements to the tr
                    let td1 = $('<td class="w-25">').text(el.question.question);
                    tr.append(td1);

                    let td2 = $('<td class="p-0">');
                    let innerTable = $('<table class="w-100">');

                    options.forEach((option) => {
                        let innerTr = $("<tr>");
                        let innerTd1 = $(
                            '<td class="" style="width: 5%">'
                        ).html(
                            '<input type="radio" name="' +
                                el.answer.id +
                                '" class="group-checkbox" data-group="group' +
                                el.answer.id +
                                '" value="' +
                                option +
                                '">'
                        );

                        let innerTd2 = $("<td>").text(option);
                        console.log(el.answer.answer);
                        console.log(option);

                        if (option == el.answer.answer) {
                            console.log("matched");

                            innerTd1 = $(
                                '<td class="" style="width: 5%">'
                            ).html(
                                '<input type="radio" name="' +
                                    el.answer.id +
                                    '" class="group-checkbox" data-group="group' +
                                    el.answer.id +
                                    '" value="' +
                                    option +
                                    '" checked>'
                            );
                        }

                        innerTr.append(innerTd1);
                        innerTr.append(innerTd2);
                        innerTable.append(innerTr);
                    });

                    td2.append(innerTable);
                    tr.append(td2);

                    // Append the tr to the table
                    checkTable.append(tr);
                });
            }

            if (textType.length > 0) {
                let textForm = $("#pib-pit-table-form");
                let textTable = $('<table class="table table-bordered">');

                textForm.append(textTable);

                textType.forEach((el) => {
                    let tr = $("<tr>");

                    // Create and append the td elements to the tr
                    let td1 = $('<td style="width: 35%">').text(
                        el.question.question
                    );
                    let td2 = $("<td >").html(
                        '<input style="width: 100%; border: none; border-bottom: 1px solid black;" type="text" name="' +
                            el.answer.id +
                            '" value="' +
                            el.answer.answer +
                            '">'
                    );
                    tr.append(td1);
                    tr.append(td2);
                    // Append the tr to the table
                    textTable.append(tr);
                });
            }

            dataFetched = true;

            if (dataFetched) {

                if(formType == 1){
                    openModalpib();
                }else if(formType == 2 ){
                    openModalpit();
                }

            }

            // let form = $("#pib-pit-table-form");

            // $("#pib-form-modal").modal("show");
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        },
    });
}


function openModalpib() {
    // Open the modal here
    $("#pib-form-modal").modal("show");
}

function openModalpit() {
    // Open the modal here
    $("#pit-form-modal").modal("show");
}


$("#pib-pit-print").click(function () {
    // Get the content of the div by its id
    var content = $("#pib-pit-form-body").html();

    // Create a new window for printing
    var printWindow = window.open('', '');

    // Write the content to the new window
    $(printWindow.document.body).html(content);
    var bootstrapCssLink = document.createElement('link');
    bootstrapCssLink.rel = 'stylesheet';
    bootstrapCssLink.href = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'; // Replace with the Bootstrap CDN URL
    printWindow.document.head.appendChild(bootstrapCssLink);

    // Trigger the print dialog
    printWindow.print();
    printWindow.close();
});



// function fetchWorkTimeInfo (id) {
//     $.ajax({
//         url: "/to-fetch-worktime",
//         method: "get",
//         data: { worktimeId: id },
//         success: function (response) {
//             console.log(response);
//             console.log("Success");

//             $('#startTime').val(response.start_time)
//             $('#endTime').val(response.end_time)
//             // $('#weekoff').val(response.weekly_off)

//             let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

//             days.forEach((day, index) => {
//                 isSelected = response.weekly_off.includes(index)
//                 $('#weekoff').append($(`<option value="${index}" ${isSelected ? 'selected' : ''}>`).text(`${day}`))
//             });

//             $("#worktimeModal").modal("show");
//         },
//         error: function (xhr) {
//             console.error(xhr.responseText);
//         },
//     });
// }

$(".pib-form-open").click(function () {
    let ticketId = $(this).data("ticket-id");
    let formType = $(this).data("form-type");

    fetchFormInfo(ticketId, formType);
});

$(".pit-form-open").click(function () {
    let ticketId = $(this).data("ticket-id");
    let formType = $(this).data("form-type");

    fetchFormInfo(ticketId, formType);
});

// $("#pib-form-modal").on("shown.bs.modal", function () {
//     let ticketId = $(this).data("ticket-id");
//     let formType = $(this).data("form-type");

//     fetchFormInfo(ticketId, formType);
//   });

$("#pib-form-modal").on("hidden.bs.modal", function () {
    $("#pib-pit-table-form").empty();
});

document
    .getElementById("pib-pit-submit")
    .addEventListener("click", function () {
        $("#pib-pit-table-form").submit();
    });
$("#pib-pit-table-form").submit(function (event) {
    event.preventDefault(); // Prevent form submission

    var formData = $(this).serialize(); // Serialize form data
    console.log(formData);

    $.ajax({
        url: $(this).attr("action"),
        type: "GET",
        data: formData,
        success: function (response) {
            // Handle success response
            console.log(response);
            Swal.fire("Success!", "Form updated", "success");
        },
        error: function (xhr) {
            // Handle error response
            console.log(xhr.responseText);
            Swal.fire("Error!", "Request failed", "error");
        },
    });
});

function getHistories(ticketId) {
    $.ajax({
        url: "/get-histories", // Replace with your Laravel route
        type: "GET",
        data: {
            id: ticketId,
        },
        success: function (response) {
            // Populate the "Assign To" select input with the retrieved users
            var history_card = $("#history-container");
            var history_header = $(
                '<div class="row"><div class="col-md-12"><h6 class="pr-3 col-2 text-right ticket_history_title">Activites</h6></div></div>'
            );

            const histories = [];
            $.each(response.histories, function (index, history) {
                var history_content = $('<div class="row"></div>');
                var col = $('<div class="col-md-12"></div>');
                var history_card = $(
                    '<div class="ticket_history_card" id="history-card"></div>'
                );
                var card = $('<div class="card"></div>');
                var card_body = $(
                    '<div class="card-body" id="history-body"></div>'
                );

                // Create two spans for comment and created_at
                var commentSpan = $('<span style="float: left;"></span>').text(history.comment);
                var createdAtSpan = $('<span style="float: right;"></span>').text(formatCreatedAt(history.created_at));


                //card_body.html(history.comment);
                //card_body.html(history.comment + ' ' + history.created_at);

                card_body.append(commentSpan);
                card_body.append(createdAtSpan);

                card.append(card_body);
                history_card.append(card);
                col.append(history_card);
                history_content.append(col);

                histories.push(history_content);
            });


            // Function to format created_at
            function formatCreatedAt(timestamp) {
                var date = new Date(timestamp);
                var options = {
                    hour: 'numeric',
                    minute: 'numeric',
                    hour12: true,
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                };
                return date.toLocaleString('en-US', options);
            }



            if (histories.length > 0) {
                histories.unshift(history_header);
            }

            history_card.html(histories);

            console.log(response.histories);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

// change assigned staff when changing department
function getUsersChanged(roleVal, assignToSelect) {
    $.ajax({
        url: "/get-role-users", // Replace with your Laravel route
        type: "GET",
        data: {
            role: roleVal,
        },
        success: function (response) {
            // Populate the "Assign To" select input with the retrieved users
            assignToSelect.empty();
            $.each(response.users, function (index, user) {
                var option = $("<option></option>")
                    .text(user.first_name)
                    .val(user.id);

                assignToSelect.append(option);
                assignToSelect.prepend(
                    $("<option></option>").val("").text("Select Staff")
                );

                assignToSelect.val("");
                assignToSelect.find('option[value=""]').prop("selected", true);
            });

            console.log(response.users);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

$(".go-back").click(function () {
    history.go(-1); // Go back one page
    console.log("click back button");
});
