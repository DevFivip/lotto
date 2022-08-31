@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" x-data="mounted()">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Configurar Impresora</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="impresora_id" class="col-md-4 col-form-label text-md-end">URL del pluggin</label>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="impresora_id" class="col-md-4 col-form-label text-md-end"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" x-model="url">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="paper_width" class="col-md-4 col-form-label text-md-end">Tamaño del Papel</label>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="paper_width" class="col-md-4 col-form-label text-md-end"></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" x-model="paper_width">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="impresora_id" class="col-md-4 col-form-label text-md-end">Listado de mis impresoras: <span x-text="printerSelected"></span></label>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label for="impresora_id" class="col-md-4 col-form-label text-md-end"></label>
                                <div class="col-md-6">
                                    <input type="text" x-model="printerSelected" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="alert alert-dark" role="alert">
                            <p>
                                Para poder enlazar tu impresora es necesario los siguientes programas, <a href="https://drive.google.com/file/d/1pUc8EK04fMcprvGIy27aAaxwI5aSnp7r/view?usp=sharing">lea la guia de instalación.</a>
                            </p>
                            <p>fivip-printer.exe</p>
                            <p>RestartOnCrash.exe</p>
                            <p>run.vbs</p>
                            <p>setting.conf</p>
                            <p>test</p>
                            <p>
                                <a href="https://drive.google.com/drive/folders/1QgOkxeYrt_SD7yZRz8hYprnXMU8VJd6Z?usp=sharing" class="btn btn-primary">💾 Descargar</a>
                            </p>
                        </div>

                    </div>
                    <div class="row mb-0">
                        <div class="col-md-12">
                            <a class="btn btn-danger" @click.prevent="deletePrinter()">
                                Eliminar Configuración
                            </a>
                            <a class="btn btn-success" @click.prevent="testPrint()">
                                Test Impresora
                            </a>
                            <a class="btn btn-primary" @click.prevent="setPrinter()">
                                Guardar Impresora
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function mounted() {
            return {
                printers: [],
                paper_width: localStorage.getItem('paper_width') || 226.772,
                url: localStorage.getItem('printer_url') || 'http://localhost:7734',
                printerSelected: localStorage.getItem('printer'),
                getPrinter: async function() {
                    axios(`${this.url}/printer-list`, {
                        method: 'GET',
                        mode: 'no-cors',
                    }).then(({
                        data
                    }) => {
                        this.printers = data
                        // console.log(data);
                    }).catch((e) => {
                        this.toast('Verifica el la url del pluggin', 3000)
                        this.toast('Asegurate que tengas instalado el pluggin de impresion en tu computadora local', 3000)
                        console.log(e);
                    });
                },
                setPrinter: function() {
                    localStorage.setItem('printer_url', this.url)
                    localStorage.setItem('printer', this.printerSelected)
                    localStorage.setItem('paper_width', this.paper_width)
                    this.toast('Impresora configurada correctamente 👌')
                },
                deletePrinter: function() {
                    localStorage.removeItem("printer_url");
                    localStorage.removeItem("printer");
                    this.printers = [];
                    this.url = "http://localhost:7734"
                    this.toast('Configuración Eliminada Correctamente se imprimira con PDF default 👌', 5000)
                },
                toast: function(msg = 'Error al eliminar', duration = 800) {
                    Toastify({
                        text: msg,
                        duration: duration,
                        className: "info",
                        close: true,
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                },
                testPrint: async function() {
                    console.log(this.printerSelected);
                    axios(`${this.url}/printer-test`, {
                        method: 'POST',
                        mode: 'no-cors',
                        data: {
                            printer: localStorage.getItem('printer')
                        }
                    }).then(({
                        data
                    }) => {
                        this.toast('Al parecer todo va bien ✌', 3000)
                        // console.log(data);
                    }).catch((e) => {
                        this.toast('Verifica el la url del pluggin', 3000)
                        this.toast('Asegurate que tengas instalado el pluggin de impresion en tu computadora local', 3000)
                        console.log(e);
                    });
                },
            }
        }
    </script>
</div>
@endsection