window.userLotForm = function(userId, initialRole, allLots) {
    return {
        role: initialRole,
        originalRole: initialRole,           // track original role
        allLots,
        selectedLots: allLots.filter(l => l.owner_id === userId),
        originalSelectedLots: allLots.filter(l => l.owner_id === userId).map(l => l.id),
        query: '',
        filteredLots: [],

        // computed property to check if changes exist
        get hasChanges() {
            // role changed
            if (this.role !== this.originalRole) return true;

            // lots changed
            const selectedIds = this.selectedLots.map(l => l.id).sort();
            const originalIds = this.originalSelectedLots.slice().sort();
            return JSON.stringify(selectedIds) !== JSON.stringify(originalIds);
        },

        filterLots() {
            const q = this.query.toLowerCase().trim();
            this.filteredLots = this.allLots.filter(lot => {
                return !this.selectedLots.find(sl => sl.id === lot.id) &&
                    (lot.name.toLowerCase().includes(q) ||
                        lot.block.toLowerCase().includes(q));
            });

        },

        selectLot(lot) {
            if (!this.selectedLots.find(sl => sl.id === lot.id)) {
                this.selectedLots.push(lot);
            }
            this.query = '';
            this.filteredLots = [];
        },

        removeLot(index) {
            this.selectedLots.splice(index, 1);
        },

        // reset form to original values
        resetForm() {
            this.role = this.originalRole;
            this.selectedLots = this.allLots.filter(l => l.owner_id === userId);
        }
    }
}

  