<div class="modal fade bd-example-modal-lg" id="pib-form-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">PIB FORMULIER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pib-pit-form-body">
                <div>
                    <h6>Pre intake beoordeling (PIB)</h6>
                    <table class="table table-bordered pib-pit-table">

                        <tr>
                            <td class="w-25">
                                Naam PiB-er:
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                Naam patiënt:
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                Patiëntcode:
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                Soort Legitimatie:
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                Documentnummer:
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                Vervaldatum legitimatie:
                            </td>
                            <td>

                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered pib-pit-table-2">
                        <tr>
                            <td colspan="2">
                                <strong>Triageformulier:</strong>
                                <p style="font-size: 12px;">Wij hebben uw verwijsbrief beoordeeld en hebben aanvullende
                                    vragen die we u willen
                                    stellen om goed een
                                    keuze te kunnen maken of wij u de juiste behandeling kunnen bieden. Het gesprek zal
                                    ongeveer 15minuten
                                    duren. Hierna zullen we u met enkele (2-3 dagen) terugbellen. Mochten wij niet de
                                    goede zorg voor u hebben,
                                    zullen we uitleggen waarom dat zo is en indien mogelijk een andere instelling
                                    adviseren. Wij zijn een
                                    diagnostisch en psychotherapeutisch centrum en verstrekken geen medicatie tijdens de
                                    behandeling. Indien
                                    nodig/nuttig zal tijdens uw behandeling bij ons de huisarts u medicatie geven.</p>
                            </td>
                        </tr>



                    </table>

                    <form id="pib-pit-table-form" method="GET" action="{{ route('update-answer') }}">
                        @csrf

                    </form>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="pib-print">Print</button>
            </div>
        </div>
    </div>
</div>
