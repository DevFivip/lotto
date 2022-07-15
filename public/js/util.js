const fill = (number, len) =>"0".repeat(len - number.toString().length) + number.toString();

function convertir_utc_to_local(_fecha) {
    const fecha = new Date(_fecha);
    const date = fecha.toLocaleString();
    const fechas = date.split(",");
    console.log(fechas);
    const f = fechas[0].split("/");
    console.log(f);
    const f2 = fechas[1];

    mes = fill(f[1], 2);
    const b = f[2] + "-" + mes + "-" + f[0] + "T" + f2.slice(1);

    console.log(b);
    return b;
}
