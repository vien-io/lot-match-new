window.userLotForm = function (userId, initialRole, allLots) {
    return {
        userId: userId,
        role: initialRole,
        originalRole: initialRole, // track original role
        saveSuccess: false,
        allLots,
        successTimer: null,
        selectedLots: allLots.filter((l) => l.owner_id === userId),
        originalSelectedLots: allLots
            .filter((l) => l.owner_id === userId)
            .map((l) => l.id),
        query: "",
        filteredLots: [],

        // computed property to check if changes exist
        get hasChanges() {
            if (this.saveSuccess && this.role !== this.originalRole) {
                this.saveSuccess = false; // reset after showing success
            }

            // role changed
            if (this.role !== this.originalRole) return true;

            // lots changed
            const selectedIds = this.selectedLots.map((l) => l.id).sort();
            const originalIds = this.originalSelectedLots.slice().sort();
            return JSON.stringify(selectedIds) !== JSON.stringify(originalIds);
        },

        async save() {
            this.saving = true;

            try {
                const url = this.$refs.form.action;

                const response = await fetch(url, {
                    method: "PATCH",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]',
                        ).content,
                    },
                    body: JSON.stringify({
                        role: this.role,
                    }),
                });

                const result = await response.json();

                if (response.ok) {
                    this.originalRole = this.role;
                    this.originalSelectedLots = this.selectedLots.map(
                        (l) => l.id,
                    );
                    clearTimeout(this.successTimer);
                    this.saveSuccess = true;
                    this.successTimer = setTimeout(() => {
                        this.saveSuccess = false;
                        this.successTimer = null;
                    }, 3000);

                    console.log("Saved:", result);
                } else {
                    console.error("Failed:", result);
                    alert(result.message || "Failed to save.");
                }
            } catch (error) {
                console.error("Save error:", error);
                alert("An unexpected error occurred.");
            } finally {
                this.saving = false;
            }
        },

        filterLots() {
            const q = this.query.toLowerCase().trim();
            this.filteredLots = this.allLots.filter((lot) => {
                return (
                    !this.selectedLots.find((sl) => sl.id === lot.id) &&
                    (lot.name.toLowerCase().includes(q) ||
                        lot.block.toLowerCase().includes(q))
                );
            });
        },

        selectLot(lot) {
            if (!this.selectedLots.find((sl) => sl.id === lot.id)) {
                this.selectedLots.push(lot);
            }
            this.query = "";
            this.filteredLots = [];
        },

        removeLot(index) {
            this.selectedLots.splice(index, 1);
        },

        // reset form to original values
        resetForm() {
            this.role = this.originalRole;
            this.selectedLots = this.allLots.filter(
                (l) => l.owner_id === userId,
            );
        },
    };
};
