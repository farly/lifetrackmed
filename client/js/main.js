const baseUrl = 'http://localhost:9090';
const FETCHING = 'Fetching...';
const btn = document.getElementById('btn');

let fetching = false;

function usd_format(number, decimal) {
	const formatter = new Intl.NumberFormat('en-US', {
		style: 'currency',
		currency: 'USD',
		minimumFractionDigits: decimal 
	});
	return formatter.format(number);
}

function format_int(number) {
	return parseInt(number).toLocaleString();
}

function toggleBtn() {
  btn.value = fetching ? FETCHING : 'Estimate';
}

function setFetching(isFetching) {
  fetching = isFetching; 
}

function createTable(data) {
  const { monthly : costs, }  = data;
  const rows = costs.map(c => {
    const row = `
      <tr>
          <td>${c.name} ${c.year}</td>
          <td>${format_int(c.total_studies)}</td>
          <td>${usd_format(c.total, 2)}</td>
      </tr>
    `;

    return row;
  });

  console.info(rows);

  const table = `
    <table class="table">
      <tr>
        <th>Month</th>
        <th>Total Studies</th>
        <th>Forecasted Cost</th>
      </tr>
      ${rows.join(" ")}
    </table>
  `;

  document.getElementById('table').innerHTML = table;
}


function request(data) {
  setFetching(true);
  toggleBtn();
  xhr = new XMLHttpRequest();
  xhr.open("POST", `${baseUrl}/cost`, true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send(JSON.stringify(data));
  xhr.onload = function() {
    const response = JSON.parse(xhr.response);
    if (xhr.status === 200) {
      const { data } = response;
      createTable(data);
    }
    setFetching(false);
    toggleBtn();
  }
}


const element = document.querySelector('form');

element.addEventListener('submit', event => {
  event.preventDefault();
  const dailyStudies = parseInt(document.getElementById('dailyStudies').value);
  const growth = parseFloat(document.getElementById('growth').value);
  const endMonth = parseInt(document.getElementById('months').value);
  const startMonth = 1;

  const data = {
    dailyStudies,
    growth,
    startMonth,
    endMonth
  };

  request(data);
});
