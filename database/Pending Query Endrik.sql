-- MOHON UNTUK RUN SQL INI, kalau sudah di Run mohon di hapus ya contentnya
-- SEMUA PENDING SQL akan saya taruh disini, jika dihapus artinya sudah di RUN atau di Sync

INSERT INTO ms_setting(key1, key2, value1, value2) VALUES('ImportTax', 'Import Tax', 10, 'number');

-- Buat menu forwarder payment
INSERT INTO lk_accesscontrol (accessID, description, node, icon)
VALUES ('C.6', 'Forwarder Payment', '/forwarder-payment', 'fa-cart-arrow-down');

INSERT INTO lk_filteraccess (accessID, insertAcc, updateAcc, deleteAcc, viewAcc)
VALUES ('C.6', 1, 1, 1, 1);

-- Apply menu forwarder payment ke semua role, for default
INSERT INTO ms_useraccess (userRole, accessID, indexAcc, viewAcc, insertAcc, updateAcc, deleteAcc, flagActive)
SELECT temp.userRole, 'C.6', 1, 1, 1, 1, 1, 1
FROM ms_useraccess AS temp GROUP By userRole;



-- Coa Settings

INSERT INTO ms_coasetting VALUES ('UMPCustomer', 'UM Penjualan Customer', '2119.0001');
INSERT INTO ms_coasetting VALUES ('ByTxBank', 'By Transfer bank', '6111.0026');
INSERT INTO ms_coasetting VALUES ('PiutangPPN', 'Piutang PPN', '1122.0002');
INSERT INTO ms_coasetting VALUES ('SelisihKursPenjualanPembelian', 'Selisih Kurs  (Penjualan & Pembelian)', '7110.0008');
INSERT INTO ms_coasetting VALUES ('SelisihKursKasBank', 'Selisih Kurs  (Kas & Bank)', '7110.0010');
INSERT INTO ms_coasetting VALUES ('RugiStockOpname', 'Rugi Stock Opname', '8110.0007');
INSERT INTO ms_coasetting VALUES ('IncomeStockOpname', 'Pendapatan Stock Opname', '7110.0011');
INSERT INTO ms_coasetting VALUES ('HutangPPNImpor', 'Hutang PPN Impor', '2115.0010');
INSERT INTO ms_coasetting VALUES ('HutangPPJK', 'Hutang kpd PPJK', '2111.0002');