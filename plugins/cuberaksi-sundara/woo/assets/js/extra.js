jQuery(document).ready(($) => {
    if ($('.extra-info-button').length)
        $('.extra-info-button').click((e) => {
            e.preventDefault()
            let el = e.currentTarget
            let orderId = e.currentTarget.dataset.extra
            fetch(`/wp-json/sundara/v1/extrainfo?orderid=${orderId}`).then((res) => res.json()).then((res) => {
                Swal.fire({
                    title: "Extra Info",
                    width: 800,
                    padding: "1em",
                    html: `
                    <style>table.extra-info td{text-align:left;font-size:medium;} table.extra-info td:first-child { font-weight:600; border-right:1px solid #c3c4c7;}</style>
                 <table class="extra-info wp-list-table widefat striped table-view-list" border='0' cellpadding='0' cellspacing='0' >
                 <tbody>
                    <tr>
                      <td>Order Id 
                      </td>
                      <td>${res.orderId}
                      </td>
                    </tr>
                    <tr>
                      <td>Mailing Address
                      </td>
                      <td>${res.mailingAddress}
                      </td>
                    </tr>
                    <tr>
                      <td>Date of Birth
                      </td>
                      <td>${res.birth}
                      </td>
                    </tr>
                      <tr>
                      <td>Dietary Restrictions
                      </td>
                      <td>${res.dietary}
                      </td>
                    </tr>
                    </tr>
                      <tr>
                      <td>Medical Issue
                      </td>
                      <td>${res.medicalIssue}
                      </td>
                    </tr>
                    <tr>
                      <td>Emergency Contact Name
                      </td>
                      <td>${res.emergencyContactName}
                      </td>
                    </tr>
                     <tr>
                      <td>Emergency Contact Email
                      </td>
                      <td>${res.emergencyContactEmail}
                      </td>
                    </tr>
                    <tr>
                      <td>Hear Trip From
                      </td>
                      <td>${res.hearFrom}
                      </td>
                    </tr>
                     <tr>
                      <td>Anything Else
                      </td>
                      <td>${res.anythingElse}
                      </td>
                    </tr>
                 </tbody>
                 </table>
                `,
                    showCloseButton: true,

                    focusConfirm: false,



                });
            })


        })
})
