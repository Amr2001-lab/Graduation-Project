# docs/Unity

## Unity Virtual Reality Tour

This guide walks you through creating a professional VR tour in Unity, using the **XR Interaction Toolkit** and a custom **Virtual Tour SDK**. You will:

* Configure Unity for VR
* Import the Virtual Tour SDK
* Set up a scene with interactive hotspots
* Implement a teleportation script
* Build the final VR application

***

### Table of Contents

1. Introduction
2. Prerequisites
3. Project Setup
   * Create a New Unity Project
   * Install XR Plugin Management
   * Import the Virtual Tour SDK
4. Scene Configuration
   * Configure the XR Rig
   * Add Waypoints
   * Set Up Hotspots
5. Scripting Teleportation
   * TeleportToRoom.cs
   * Code Breakdown
6. Building the Project
7. Conclusion

***

### Introduction

Build an interactive VR tour that lets users click (or gaze) on hotspots to move seamlessly between scenes. This guide covers everything from initial setup to final build.

***

### Prerequisites

* **Unity Editor** (2021.3 LTS or later) via _Unity Hub_\
  &#xNAN;_&#x49;nclude platform modules for your target (Windows, Android, etc.)_
* **XR Plugin Management** & **XR Interaction Toolkit** (via Package Manager)
* **VR Headset** compatible with your platform
* **Virtual Tour SDK** package (`.unitypackage`)

***

### Project Setup

#### Create a New Unity Project

1. Open **Unity Hub** → **New**
2. Choose **3D (URP)** or **3D** template
3. Name it `VRVirtualTour` and set your project location
4. Click **Create Project**

#### Install XR Plugin Management

1. **Window** → **Package Manager**
2. Install **XR Plugin Management** and **XR Interaction Toolkit**

![Figure 1 – Installing XR Plugin Management & XR Interaction Toolkit](.gitbook/assets/image16.jpg)

3. **Edit** → **Project Settings** → **XR Plug-in Management**
4. Enable your platform loader (e.g., **Oculus**, **Windows XR**)

#### Import the Virtual Tour SDK

1. **Assets** → **Import Package** → **Custom Package…**
2. Select `VirtualTourSDK.unitypackage`
3. Click **Import**

![Figure 2 – Import the Virtual Tour SDK via Assets → Import Package → Custom Package](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FbgOktcaaRB0siWaGk8EU%2Fimage1.png%3Falt%3Dmedia%26token%3D14e40188-3170-4faf-a88d-501301a8c1e1)

***

### Scene Configuration

#### Configure the XR Rig

1. In the **Hierarchy**, delete **Main Camera**
2. Drag **XR Rig** prefab from `Assets/VirtualTourSDK/Prefabs` into the scene
3. Set its **Transform** to `(0, 0, 0)`
4. In **Inspector**, set **Tracking Origin** = **Floor**

![Figure 3 – XR Rig setup in the Scene Hierarchy](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FhkWJZGOKkLtSfjHSXyuN%2Fimage2.png%3Falt%3Dmedia%26token%3D8b5563e1-a751-4e9a-9d56-653e4562fd65)

#### Add Waypoints

1. **Hierarchy** → **Create Empty** → rename to `Waypoint_A`
2. Position at your scene’s entry (e.g., `(2, 0, 5)`)
3. Repeat for `Waypoint_B`, `Waypoint_C`, …
4. _(Optional)_ Add a small sphere or icon for visibility

![Figure 4 – Waypoint positioning example](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FJX7CLSunF9u6yXjhNg6o%2Fimage3.png%3Falt%3Dmedia%26token%3D59d2466d-00ca-4dff-94e7-b49f1401ff79)

#### Set Up Hotspots

1. Under each waypoint → **Create Empty** → rename to `Hotspot`
2. Attach a 3D model or UI icon
3. Add **Box Collider** → check **Is Trigger**
4. Attach the **TeleportToRoom** script
5. In **Inspector**, set **Target Scene**, **Entry Position**, **Entry Rotation**

![Figure 5 – Hotspot configuration in Inspector](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FAg230hnxwawp7KZSjVZG%2Fimage4.png%3Falt%3Dmedia%26token%3Dbaf4628a-0069-4b52-9184-35f86267883a)

<figure><img src=".gitbook/assets/image13.jpg" alt=""><figcaption></figcaption></figure>

***

### Scripting Teleportation

#### TeleportToRoom.cs

Create **`Assets/Scripts/TeleportToRoom.cs`**:

![Figure 6 – TeleportToRoom.cs in Assets/Scripts](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FYIwZK8QuWyldwuPV8HMy%2Fimage7.png%3Falt%3Dmedia%26token%3D565997fa-dffa-4a2b-91c6-ec85ef4c3f1e)

```csharp
using UnityEngine;
using UnityEngine.SceneManagement;
using System.Collections;

public class TeleportToRoom : MonoBehaviour
{
    [Header("Teleport Settings")]
    public string   targetScene;    // Scene to load
    public Vector3  entryPosition;  // Player position after load
    public Vector3  entryRotation;  // Player rotation after load

    private bool isLoading = false;

    void Update()
    {
        if (!isLoading && Input.GetKeyDown(KeyCode.T))
            StartCoroutine(LoadAndTeleport());
    }

    void OnMouseDown()
    {
        if (!isLoading)
            StartCoroutine(LoadAndTeleport());
    }

    private IEnumerator LoadAndTeleport()
    {
        isLoading = true;
        var asyncLoad = SceneManager.LoadSceneAsync(targetScene);
        while (!asyncLoad.isDone) yield return null;

        var xrRig = FindObjectOfType<XRRig>();
        if (xrRig != null)
        {
            xrRig.transform.position    = entryPosition;
            xrRig.transform.eulerAngles = entryRotation;
        }
        isLoading = false;
    }
}
```

***

### Building the Project

1. **File** → **Build Settings**
2. Add all VR scenes to **Scenes In Build**

![Figure 8 – Scenes added to Build Settings](.gitbook/assets/image15.jpg)

3. Select your target platform → click **Switch Platform**

![Figure 9 – Switching target platform](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FADfmoDXzGOvbD7lSFOAT%2Fimage10.png%3Falt%3Dmedia%26token%3D39e1ef75-ff9f-4403-a9d5-7568122b527a)

4. In **Player Settings**, verify **XR Plug-in Management** and graphics API

![Figure 10 – Player Settings → XR Plug-in Management](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2F5Nv6vOKYu7dSYFtcr5pa%2Fimage11.png%3Falt%3Dmedia%26token%3D74d53750-5ee3-4cc9-816f-b52864211ba7)

5. Click **Build** or **Build And Run**, then choose an output folder

![Figure 11 – Build And Run dialog](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FkyRlZdQzKWqyL2jyVwAQ%2Fimage8.png%3Falt%3Dmedia%26token%3Ddd584402-8f91-41d2-b8ba-ae4a57d78edc)

***

### Conclusion

You now have a fully functional VR tour with clickable hotspots and smooth teleportation. Next steps could include:

* **Audio narration** per room\
  ![Figure 12 – Adding audio narration to hotspots](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FYOnbOHANSkh2YxSw4vLc%2Fimage13.jpg%3Falt%3Dmedia%26token%3Df08d48e5-d6a3-45ef-9a06-3a0389d8dc35)
* **Gaze-based UI**\
  ![Figure 13 – Gaze-based UI sample](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2FFRZKCW03GuU1rcDHCDCq%2Fimage14.jpg%3Falt%3Dmedia%26token%3D20d09b5f-3b75-407c-993d-2785fa4f6799)
* **Analytics** to track user movement\
  ![Figure 14 – Analytics dashboard example](https://www.gitbook.com/cdn-cgi/image/dpr=2,width=1024,onerror=redirect,format=auto/https%3A%2F%2Ffiles.gitbook.com%2Fv0%2Fb%2Fgitbook-x-prod.appspot.com%2Fo%2Fspaces%2FMAvAo0QwMYDWyWa7JkCQ%2Fuploads%2F2szvfTuidZLAqpm2BJJq%2Fimage15.jpg%3Falt%3Dmedia%26token%3D61a4a548-2cc9-4fe7-b69e-c8024140837f)
