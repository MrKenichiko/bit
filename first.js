const dept = execution.getVariable("dept");
const url = 'https://staging-svt.iss-reshetnev.ru/api/v4/graphics/info/dept/${dept}';

fetch(url, {
  method: "POST",
  headers: {
    "Content-Type": "application/json"
  }
})
.then(response => response.json())
.then(data => {
  const workplaceCount = data.workplace_count;
  execution.setVariable("workplace_count", workplaceCount);
})
.catch(error => {
  console.error("Error fetching workplace count:", error);
  execution.setVariable("workplace_count", 0);
});
