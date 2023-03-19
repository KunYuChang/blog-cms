# 專案標題

這是一個小型的部落格功能
- 使用者可以閱讀文章、對文章留言、搜尋文章。
- 管理者可以對文章進行新增、發布、修改、刪除。

## 技術使用

- HTML, CSS, JavaScript
- Bootstrap, jQuery
- Google Charts
- PHP, MySQL


## 安裝說明

1. 安裝 Laragon，並啟動 Laragon。
2. 將專案下載後解壓縮至 Laragon 的 「www」 資料夾中。
3. 開啟 DBeaver，新增一個 MySQL 資料庫，執行專案中的 schema.sql。
4. 使用 Composer 安裝 PHPMailer。
5. 網址列輸出專案名稱.test，詳細可參考 Laragon 運行專案的規則。

## URL 重寫規則

1. 首頁路由(index)：改寫為 index.php
2. 聯絡我們路由(contact)：改寫為 contact.php
3. 註冊路由(registration)：改寫為 registration.php
4. 文章路由(post)：/post/文章ID 轉換為 post.php?p_id=文章ID
5. 分類路由(category)：/category/分類ID 轉換為 post.php?category=分類ID


## 技術範圍

1. 註冊功能/登入功能/密碼加密
2. 分頁功能
3. 忘記密碼功能/寄信功能
4. 文章新增/修改/刪除/複製

## 警語

1. 這個專案在安全性方面可能存在風險，使用者的個人資料可能有被竊取的風險，建議進一步加強安全性。
2. 程式碼結構可能需要進一步優化，以增強可讀性、維護性和擴展性。
3. 建議使用 PDO 取代 mysqli
4. 建議使用 autoload 取代 require
5. 建議將程式碼改寫成物件導向架構（OOP），以提高代碼的可重用性和可維護性。

