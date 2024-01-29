// export function testAlert() {
//     alert("The JavaScript file is imported properly!");
// }

function comma(Num) {
    //function to add commas to textboxes
    // $("#value").val($("#value").val().replace(/[^0-9,]/g, ''));
    Num = parseFloat(Num).toFixed(0)
    Num += ""
    Num = Num.replace(",", "")
    Num = Num.replace(",", "")
    Num = Num.replace(",", "")
    Num = Num.replace(",", "")
    Num = Num.replace(",", "")
    Num = Num.replace(",", "")
    // Num = Num.replace(',', '');
    let x, x1, x2
    x = Num.split(".")
    x1 = x[0]
    x2 = x.length > 1 ? "." + x[1] : ""
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) x1 = x1.replace(rgx, "$1" + "," + "$2")
    return x1 + x2
  }

  let sku_id = document.querySelectorAll('.sku_id')
  let sku_idd = document.querySelectorAll('.sku_id')

  
//   sku_id.innerHTML =`₦${comma(Number(sku_id))}`
//   sku_id.map((item) => item.textContent = comma(item) )

for (let i = 0; i < sku_id.length; i++) {
    sku_id[i].innerText = `${comma( sku_id[i].innerText)}`;
  }

  console.log('sku_id',sku_idd);
  console.log('sku_id', sku_id );
