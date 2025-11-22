const searchInput = document.getElementById("searchInput");
if (searchInput) {
  searchInput.addEventListener("input", function (e) {
    let val = this.value;
    let sugg = document.getElementById("suggestions");

    if (!sugg) return;

    if (val.length < 2) {
      sugg.style.display = "none";
      return;
    }

    fetch(`autocomplete.php?term=${encodeURIComponent(val)}`)
      .then((r) => r.json())
      .then((data) => {
        sugg.innerHTML = "";

        if (data.length === 0) {
          sugg.style.display = "none";
          return;
        }

        data.forEach((title) => {
          let div = document.createElement("div");
          div.className = "autocomplete-item";
          div.innerHTML = `<i class="fas fa-book"></i> ${title}`;
          div.onclick = () => {
            e.target.value = title;
            sugg.style.display = "none";
          };
          sugg.appendChild(div);
        });

        sugg.style.display = "block";
      })
      .catch((err) => {
        console.error("Autocomplete error:", err);
      });
  });

  // Hide suggestions when clicking outside
  document.addEventListener("click", (e) => {
    const sugg = document.getElementById("suggestions");
    if (
      sugg &&
      !e.target.closest("#searchInput") &&
      !e.target.closest("#suggestions")
    ) {
      sugg.style.display = "none";
    }
  });
}
