# 專案開發進度紀錄 - Docker + phpstudy (小皮面板) 環境建置

## 📅 日期: 2025-11-28
## 🎯 專案目標
在 Windows 環境下，利用 Docker 部署 Ubuntu 容器，運行小皮面板 (phpstudy)，並成功建置支持 HTTPS 的本地開發環境。

## ✅ 達成里程碑 (Milestones)
1. **環境建置**：成功將 Docker 基礎鏡像從過時的 Ubuntu 14.04 升級至 Ubuntu 20.04，確保兼容性。
2. **面板安裝**：在 Docker 容器中成功安裝並運行小皮面板 (XP Panel)。
3. **SSL 證書生成**：使用 OpenSSL 手動生成自簽名證書 (Self-signed Certificate)。
4. **站點部署**：在面板中成功添加站點，並配置 HTTPS 強制跳轉。
5. **域名解析**：成功修改 Windows `hosts` 文件，實現 `test.local` 本地解析。
6. **最終驗證**：瀏覽器成功訪問 `https://test.local`，並正確顯示 PHP 測試頁面。

## 🛠️ 遇到的問題與解決方案 (Issues & Solutions)

### 1. 基礎鏡像版本過舊
*   **問題**：原專案使用 Ubuntu 14.04，導致小皮面板安裝失敗，提示找不到對應版本。
*   **解決**：修改 `Dockerfile`，將 `FROM ubuntu:14.04` 更改為 `FROM ubuntu:20.04`，並重新構建鏡像。

### 2. 安裝腳本證書錯誤
*   **問題**：使用 `wget` 下載安裝腳本時出現 SSL 證書過期錯誤。
*   **解決**：在命令中加入 `--no-check-certificate` 參數繞過驗證。

### 3. 面板命令無法識別
*   **問題**：輸入 `phpstudy` 或 `xp` 命令提示找不到。
*   **解決**：找到執行檔完整路徑 `/usr/local/phpstudy/system/phpstudyctl`，使用完整路徑進行操作。

### 4. 系統目錄權限報錯
*   **問題**：上傳文件後，面板報錯「您修改了面板程序，這是不允許的」，導致無法登入。
*   **解決**：進入容器終端，執行修復命令 `/usr/local/phpstudy/system/phpstudyctl -repair` 並重啟容器。

### 5. Windows Hosts 文件權限
*   **問題**：嘗試透過腳本修改 `C:\Windows\System32\drivers\etc\hosts` 時被拒絕訪問。
*   **解決**：提供完整內容，由用戶使用管理員權限手動修改，成功添加 `127.0.0.1 test.local` 並保留了原有的封鎖清單。

### 6. 缺少自簽名證書功能
*   **問題**：面板內建功能無法直接創建自簽名證書。
*   **解決**：在容器內使用 `openssl` 命令手動生成 `.key` 和 `.crt` 文件，並填入面板 SSL 設置中。

## 📂 重要文件位置
*   **專案根目錄**: `c:\Users\kaich\Desktop\php實作2`
*   **Web 根目錄 (映射)**: `c:\Users\kaich\Desktop\php實作2\www\admin\test.local_80\wwwroot`
*   **證書文件**:
    *   Key: `www/test_https/selfsigned.key`
    *   Cert: `www/test_https/selfsigned.crt`
*   **Dockerfile**: `docker-win-ubuntu-phpstudy-main/docker-win-ubuntu-phpstudy-main/Dockerfile`

## 🚀 下一步建議
*   直接在 `wwwroot` 目錄下開始 PHP 程式開發。
*   如果需要管理數據庫，可通過小皮面板創建 MySQL 數據庫。
