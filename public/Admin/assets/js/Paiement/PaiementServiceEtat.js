$(document).ready(function () {
    // Fonction pour obtenir l'année en cours
    function getCurrentYear() {
        return (new Date()).getFullYear();
    }

    // Fonction pour effectuer la requête AJAX
    function fetchData(year) {
        var url = new URL(window.location.href);
        var louerid = url.pathname.split('/').pop();

        $.ajax({
            url: '/Paiement/EtatDePaiement/' + louerid + '/' + year,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var cible = $('#cible');
                cible.empty();

                var html = '<table class="table table-bordered border-black mb-0 tablePaiament w-100">';
                html += '<thead><tr><th></th>';

                $.each(data.mois["$values"], function (index, mois) {
                    html += '<th>' + mois + '</th>';
                });

                html += '<th>Solde</th></tr></thead><tbody><tr><th scope="row">2022-2023</th>';

                $.each(data.paiementsmois["$values"], function (index, paiement) {
                    html += '<th>';
                    console.log(paiement + "Autre" + index);
                    if (paiement === "no") {
                        html += '<button type="button" class="btn btn-danger"><i class="bx bx-x"></i></button>';
                    } else {
                        html += '<button type="button" class="btn btn-success"><i class="bx bx-check-circle"></i></button>';
                    }
                    html += '</th>';
                });

                html += '<th>' + data.MontantDepaiment + ' MAD</th></tr></tbody></table>';

                cible.html(html);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
    var currentYear = getCurrentYear();
    fetchData(currentYear);

    $("#annesSelectioner").change(function () {
        var selectedYear = $(this).val();
        fetchData(selectedYear);
    });
});
