<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Research Centers</title>
    <style>
        @media print {
            #printButton, #downloadButton {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 30px;
        }

        h1 {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-bottom: 20px;
            position: relative;
        }

        h1::after {
            content: '';
            display: block;
            height: 4px;
            background-color: blue;
            width: 100%;
            position: absolute;
            bottom: -10px;
            left: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h1>Research Center Details</h1>

<table id="researchCentersTable">
    <thead>
        <tr>
            <th>Research Center</th>
            <th>Institution</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($researchCenters)): ?>
            <?php foreach ($researchCenters as $center): ?>
                <tr>
                    <td><?= htmlspecialchars($center->center_name) ?></td>
                    <td><?= htmlspecialchars($center->institution_name) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">No Research Centers found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="has-text-centered">
    <button id="downloadButton" onclick="downloadPDF()">Download as PDF</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Title
        doc.setFontSize(18);
        doc.text('Research Center Details', 14, 20);

        // Table header
        doc.setFontSize(12);
        doc.text('Research Center', 14, 30);
        doc.text('Institution', 100, 30);

        // Table rows
        let y = 40;
        const table = document.getElementById("researchCentersTable").getElementsByTagName('tbody')[0];
        for (let i = 0; i < table.rows.length; i++) {
            let row = table.rows[i];
            let centerName = row.cells[0].innerText;
            let institutionName = row.cells[1].innerText;
            doc.text(centerName, 14, y);
            doc.text(institutionName, 100, y);
            y += 10;
        }

        // Save the PDF
        doc.save('research_centers.pdf');
    }
</script>

</body>
</html>
