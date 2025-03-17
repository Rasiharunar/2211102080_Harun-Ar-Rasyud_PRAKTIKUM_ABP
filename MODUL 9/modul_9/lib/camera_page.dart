// camera_page.dart
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:camera/camera.dart';
import 'package:path_provider/path_provider.dart';
import 'package:path/path.dart' as path;
import 'package:permission_handler/permission_handler.dart';

class CameraPage extends StatefulWidget {
  const CameraPage({Key? key}) : super(key: key);

  @override
  _CameraPageState createState() => _CameraPageState();
}

class _CameraPageState extends State<CameraPage> with WidgetsBindingObserver {
  CameraController? _controller;
  List<CameraDescription> cameras = [];
  bool _isCameraInitialized = false;
  bool _isRearCameraSelected = true;
  bool _isFlashOn = false;

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addObserver(this);
    _setupCameras();
  }

  Future<void> _setupCameras() async {
    await _requestCameraPermission();
    try {
      cameras = await availableCameras();
      if (cameras.isEmpty) {
        return;
      }
      _initCamera(cameras[0]);
    } catch (e) {
      print('Error initializing camera: $e');
    }
  }

  Future<void> _requestCameraPermission() async {
    final status = await Permission.camera.request();
    if (status != PermissionStatus.granted) {
      showDialog(
        context: context,
        builder:
            (context) => AlertDialog(
              title: const Text('Camera Permission'),
              content: const Text(
                'Camera permission is required to use this app.',
              ),
              actions: [
                TextButton(
                  child: const Text('OK'),
                  onPressed: () => Navigator.pop(context),
                ),
              ],
            ),
      );
    }

    final storageStatus = await Permission.storage.request();
    if (storageStatus != PermissionStatus.granted) {
      showDialog(
        context: context,
        builder:
            (context) => AlertDialog(
              title: const Text('Storage Permission'),
              content: const Text(
                'Storage permission is required to save photos.',
              ),
              actions: [
                TextButton(
                  child: const Text('OK'),
                  onPressed: () => Navigator.pop(context),
                ),
              ],
            ),
      );
    }
  }

  Future<void> _initCamera(CameraDescription cameraDescription) async {
    _controller = CameraController(cameraDescription, ResolutionPreset.high);

    try {
      await _controller!.initialize();
      setState(() {
        _isCameraInitialized = true;
      });
    } catch (e) {
      print('Error initializing camera: $e');
    }
  }

  @override
  void dispose() {
    WidgetsBinding.instance.removeObserver(this);
    _controller?.dispose();
    super.dispose();
  }

  @override
  void didChangeAppLifecycleState(AppLifecycleState state) {
    if (_controller == null || !_controller!.value.isInitialized) {
      return;
    }
    if (state == AppLifecycleState.inactive) {
      _controller?.dispose();
    } else if (state == AppLifecycleState.resumed) {
      if (_controller != null) {
        _initCamera(_controller!.description);
      }
    }
  }

  void _toggleCameraDirection() async {
    if (cameras.length < 2) return;

    setState(() {
      _isCameraInitialized = false;
    });

    CameraDescription selectedCamera = cameras[_isRearCameraSelected ? 1 : 0];

    await _initCamera(selectedCamera);

    setState(() {
      _isRearCameraSelected = !_isRearCameraSelected;
    });
  }

  void _toggleFlash() async {
    if (_controller == null || !_controller!.value.isInitialized) return;

    try {
      if (_isFlashOn) {
        await _controller!.setFlashMode(FlashMode.off);
      } else {
        await _controller!.setFlashMode(FlashMode.torch);
      }
      setState(() {
        _isFlashOn = !_isFlashOn;
      });
    } catch (e) {
      print('Error toggling flash: $e');
    }
  }

  Future<void> _takePicture() async {
    if (_controller == null || !_controller!.value.isInitialized) {
      return;
    }

    try {
      final XFile photo = await _controller!.takePicture();

      // Save image to app directory
      final directory = await getApplicationDocumentsDirectory();
      final filename = path.basename(photo.path);
      final savedImage = await File(
        photo.path,
      ).copy('${directory.path}/$filename');

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Photo saved!'),
          duration: Duration(seconds: 2),
        ),
      );
    } catch (e) {
      print('Error taking picture: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    if (!_isCameraInitialized) {
      return Container(
        color: Colors.black,
        child: const Center(child: CircularProgressIndicator()),
      );
    }

    return Scaffold(
      backgroundColor: Colors.black,
      body: SafeArea(
        child: Stack(
          children: [
            // Camera Preview
            Positioned.fill(
              child: AspectRatio(
                aspectRatio: _controller!.value.aspectRatio,
                child: CameraPreview(_controller!),
              ),
            ),

            // Top controls
            Positioned(
              top: 20,
              left: 0,
              right: 0,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  IconButton(
                    icon: Icon(_isFlashOn ? Icons.flash_on : Icons.flash_off),
                    color: Colors.white,
                    iconSize: 28,
                    onPressed: _toggleFlash,
                  ),
                ],
              ),
            ),

            // Bottom controls
            Positioned(
              bottom: 30,
              left: 0,
              right: 0,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  // Camera Switch Button
                  Container(
                    width: 60,
                    height: 60,
                    decoration: const BoxDecoration(
                      shape: BoxShape.circle,
                      color: Colors.black38,
                    ),
                    child: IconButton(
                      icon: const Icon(
                        Icons.flip_camera_ios_outlined,
                        color: Colors.white,
                        size: 30,
                      ),
                      onPressed: _toggleCameraDirection,
                    ),
                  ),

                  // Shutter Button
                  GestureDetector(
                    onTap: _takePicture,
                    child: Container(
                      width: 80,
                      height: 80,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        border: Border.all(color: Colors.white, width: 5),
                        color: Colors.white24,
                      ),
                      child: const Center(
                        child: Icon(
                          Icons.camera,
                          color: Colors.white,
                          size: 40,
                        ),
                      ),
                    ),
                  ),

                  // Placeholder for balance
                  const SizedBox(width: 60, height: 60),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
