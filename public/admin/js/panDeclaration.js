document.addEventListener('DOMContentLoaded', function () {
    const panStatus = document.getElementById('pan_status');
    const panFields = document.getElementById('panFields');
    const documentSection = document.getElementById('documentSection');
    const downloadLink = document.getElementById('downloadLink');

    function toggleFields() {
        if (panStatus.value === 'Yes') {
            panFields.style.display = 'block';
            documentSection.style.display = 'none';
        } else {
            panFields.style.display = 'none';
            documentSection.style.display = 'block';
            generatePANDeclaration();
        }
    }

    function generatePANDeclaration() {
        const name = document.getElementById('emp_name')?.value || 'Your Name';
        const address = document.getElementById('address')?.value || 'Your Address';
        const city = document.getElementById('location')?.value || 'City';
        const state = document.getElementById('statename')?.value || 'State';
        const zip = document.getElementById('candidate_zip')?.value || 'ZIP Code';
        const email = document.getElementById('email')?.value || 'your.email@example.com';
        const phone = document.getElementById('phone1')?.value || 'Your Phone Number';
        const today = new Date().toLocaleDateString();

        const content = `
[${name}]
[${address}]
[${city}, ${state}, ${zip}]
[${email}]
[${phone}]

Date: ${today}

Subject: Declaration Regarding Non-Availability of PAN Card

Dear Sir/Madam,

I, ${name}, hereby declare that I do not currently possess a PAN (Permanent Account Number) card.
I confirm that I have not been issued one as of now.

I kindly request you to take this declaration into consideration.
If any further documentation or information is required, please feel free to contact me.

Thank you for your attention to this matter.

Sincerely,
${name}

[Your Signature (if submitting a hard copy)]
        `;

        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);

        downloadLink.href = url;
        downloadLink.download = "PAN_Declaration.doc";

        downloadLink.style.display = "block";
    }

    toggleFields();

    panStatus.addEventListener('change', toggleFields);
});
