# Project Specification: GoFun Cloud Slot Games

## 1. 專案概觀 (Project Overview)
*   **專案名稱**: GoFun Cloud Slot Games
*   **目標**: 建立一個基於 Web 的 Slot Game (老虎機) 平台。
*   **核心功能**:
    *   純粹的遊戲體驗，無需用戶註冊/登入 (Guest Play)。
    *   基於瀏覽器的響應式設計 (Mobile/Desktop)。
*   **技術棧**:
    *   **Backend**: Native PHP (無大型框架，保持輕量高效)。
    *   **Frontend**: HTML5, CSS3, JavaScript (用於老虎機動畫與邏輯)。
    *   **Infrastructure**: Docker on Ubuntu 24.04 VPS.
    *   **Network**: Cloudflare (DNS + SSL/HTTPS).

## 2. 伺服器與架構 (Server & Architecture)

### A. 基礎設施 (Infrastructure)
*   **VPS Provider**: Hostinger (或其他)
*   **OS**: Ubuntu 24.04 LTS
*   **IP**: `72.60.198.67`
*   **Access**: SSH (`root`)

### B. 容器化架構 (Docker Stack)
我們將在 VPS 上部署與本地一致的 Docker 環境，確保開發與生產環境同步。
*   **Web Server**: Nginx (輕量級，處理靜態資源與反向代理)。
*   **App Server**: PHP-FPM (處理後端邏輯)。
*   **SSL**: 由 Cloudflare Edge 處理 HTTPS，伺服器端配置 Origin Certificate 或使用 Flexible 模式。

## 3. 網絡與域名 (Network & Domain)
*   **Domain**: `gofun.cloud`
*   **DNS Provider**: Cloudflare (`adelaide.ns.cloudflare.com`, `cash.ns.cloudflare.com`)
*   **DNS Records (需配置)**:
    *   `A` record: `@` -> `72.60.198.67` (Proxied by Cloudflare)
    *   `A` record: `www` -> `72.60.198.67` (Proxied by Cloudflare)
*   **SSL/HTTPS**: 
    *   Cloudflare SSL/TLS 模式: **Full (Strict)** 或 **Full**。
    *   這意味著我們需要在 VPS 上也配置證書（可使用 Cloudflare Origin CA 證書，這比自簽名更好）。

## 4. 開發工作流 (Development Workflow) - Method B

### 流程圖
1.  **本地開發 (Local Dev)**: 在 Windows 本地 Docker 環境編寫代碼。
2.  **版本控制 (Git)**: 提交代碼到私有 Git 倉庫 (GitHub/GitLab)。
3.  **部署 (Deploy)**: SSH 連線到 VPS，執行 `git pull` 拉取最新代碼。
4.  **生效**: 代碼即時生效 (PHP 特性)，無需重新編譯。

## 5. 遊戲邏輯設計 (Game Logic)
由於不需要註冊，遊戲將採用 **Session** 或 **LocalStorage** 來暫存用戶的「分數」。

### A. 前端 (Frontend - JS)
*   負責 UI 渲染、滾輪動畫、音效播放。
*   發送 `POST` 請求給後端獲取開獎結果。

### B. 後端 (Backend - PHP)
*   **API Endpoint**: `/api/spin.php`
*   **功能**:
    1.  接收下注請求。
    2.  執行 RNG (隨機數生成) 算法決定結果。
    3.  計算中獎金額。
    4.  返回 JSON 格式結果 (例如: `{ symbols: [1, 3, 1], win: 500 }`)。
*   **安全性**: 雖然無金流，但將核心邏輯放在 PHP 端可防止前端直接修改中獎機率。

## 6. 實施步驟 (Action Plan)

### Phase 1: 基礎建設 (Infrastructure)
1.  [ ] 配置 Cloudflare DNS 指向 VPS IP。
2.  [ ] SSH 連入 VPS，進行系統更新與 Docker 安裝。
3.  [ ] 在 VPS 上部署 Nginx + PHP Docker 容器。

### Phase 2: 開發環境 (Development Setup)
1.  [ ] 初始化 Git 倉庫。
2.  [ ] 建立基礎 PHP 結構 (Router, API Response Helper)。
3.  [ ] 建立基礎前端頁面 (HTML5 Canvas 或 DOM 結構)。

### Phase 3: 遊戲開發 (Game Implementation)
1.  [ ] 實現老虎機核心算法 (PHP)。
2.  [ ] 實現前端轉動動畫 (JS)。
3.  [ ] 整合前後端。

### Phase 4: 上線與優化 (Launch)
1.  [ ] 配置 HTTPS (Cloudflare Origin Cert)。
2.  [ ] 壓力測試與優化。
