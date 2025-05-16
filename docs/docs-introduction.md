---
description: docs/Introduction.md
---

# docs/Introduction

## Introduction

### Overview

The **Real-Estate Platform** is a Laravel-based web application that connects property **sellers** with potential **buyers**.\
Sellers list apartments or houses for sale; buyers search, bookmark, compare, and send inquiries—all from a single, responsive interface.

### Problem Statement

Traditional property hunting involves scattered listings, inconsistent data, and limited direct communication.\
This platform centralises listings, standardizes information, and enables buyers to reach sellers instantly, streamlining the sales process for both parties.

### Goals

* **One-stop marketplace** for residential property sales.
* **Transparent information**: consistent pricing, location, photos, and optional 360° virtual tours.
* **Efficient communication**: built-in inquiry system; sellers manage messages in one dashboard.
* **Scalable architecture** using Laravel MVC and MySQL.

### Target Audience

| Role                        | Needs & Benefits                                                                                                                                                                      |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Buyers**                  | <p>• Search &#x26; filter listings by city, price, rooms, age<br>• Save favourites for later<br>• Compare two properties side-by-side<br>• Contact sellers without intermediaries</p> |
| **Sellers / Agents**        | <p>• Create, edit, and delete listings<br>• Upload multiple images and optional virtual-tour ZIPs<br>• Receive and manage buyer inquiries in a single dashboard</p>                   |
| **Evaluators / Developers** | <p>• Clear codebase demonstrating Laravel best practices<br>• Well-documented system design and database schema</p>                                                                   |

### Key Features (Implemented)

* **Manual Session-Based Authentication** (custom login/register via `Auth::attempt`)
* **Role-based workflows** for buyers and sellers
* **Advanced filtering** (city, price range, rooms, property age, date posted)
* **Bookmarks & Profile dashboard** for saved properties
* **Property comparison**: two listings shown side-by-side
* **Inquiry system** with email notification to sellers
* **Price Estimator**: suggests market value based on city, size, age, and rooms
* **Database-backed sessions** and **queue-powered email** for reliability

### Tech Snapshot

| Layer     | Stack                                       |
| --------- | ------------------------------------------- |
| Front-End | Blade templates · Tailwind CSS · Vanilla JS |
| Back-End  | Laravel 10 · PHP 8.2                        |
| Data      | MySQL 8 (`real_estate` schema)              |
| Hosting   | Apache (XAMPP)                              |
| Auth      | Custom session guard (`web`)                |
