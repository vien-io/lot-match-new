// resources/js/components/lotSelector.js
console.log("lotSelector loaded");

window.lotSelector = function (userId, allLots) {
    return {
        allLots: allLots, // all lots from backend
        selectedLots: allLots.filter(l => l.owner_id === userId), // pre-selected lots
        query: '',
        filteredLots: [],

        // Only lots that are not selected and match the query
        filterLots() {
            const q = this.query.toLowerCase().trim();
            this.filteredLots = this.allLots.filter(lot => {
                return !this.selectedLots.find(sl => sl.id === lot.id) &&
                       lot.name.toLowerCase().includes(q);
            });
        },

        // Select a lot safely
        selectLot(lot) {
            const exists = this.allLots.find(l => l.id === lot.id);
            if (!exists) return; // prevent invalid lot
            if (!this.selectedLots.find(sl => sl.id === lot.id)) {
                this.selectedLots.push(lot);
            }
            this.query = '';
            this.filteredLots = [];
        },

        // Remove a lot from selection
        removeLot(index) {
            this.selectedLots.splice(index, 1);
        },

        // Optional: auto-add if only one filtered result
        addLot() {
            if (this.filteredLots.length === 1) {
                this.selectLot(this.filteredLots[0]);
            }
        }
    }
};




