@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">

                @include('top_bar')

                <!-- no notes available -->
                 @if(count($notes) == 0)

                <div class="row mt-5">
                    <div class="col text-center">
                        <p class="display-6 mb-5 text-secondary opacity-50">You have no notes available!</p>
                        <a href="{{ route('new') }}" class="btn btn-secondary btn-lg p-3 px-5">
                            <i class="fa-regular fa-pen-to-square me-3"></i>Create Your First Note
                        </a>
                    </div>
                </div>

                @else 

                <!-- notes are available -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('new') }}" class="btn btn-secondary px-3">
                        <i class="fa-regular fa-pen-to-square me-2"></i>New Note
                    </a>
                </div>
                
                @foreach($notes as $note)
                @include('note')
                @endforeach
                    <!-- Modal único para WhatsApp -->
                    <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="whatsappModalLabel">Enviar nota por WhatsApp</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                    <label for="phoneNumber" class="form-label">Número do WhatsApp (com DDD):</label>
                                    <input type="text" class="form-control" id="phoneNumber" placeholder="Ex: 55999887766">
                                    </div>
                                    <input type="hidden" id="noteTitle">
                                    <input type="hidden" id="noteText">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-success" onclick="sendWhatsAppMessage()">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
    function openWhatsAppForm(title, text) {
        document.getElementById('noteTitle').value = title;
        document.getElementById('noteText').value = text;
        new bootstrap.Modal(document.getElementById('whatsappModal')).show();
    }

    function sendWhatsAppMessage() {
        const phone = document.getElementById('phoneNumber').value.trim();
        const title = document.getElementById('noteTitle').value;
        const text = document.getElementById('noteText').value;

        if (!phone) {
            alert("Informe um número de telefone.");
            return;
        }

        const message = `*${title}*\n\n${text}`;
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
    }
</script>
@endsection
