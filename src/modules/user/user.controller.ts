import {
  Get,
  Param,
  Controller,
  Post,
  Body,
  Patch,
  Delete,
} from '@nestjs/common';
import { UserService } from './user.service';

@Controller('users')
export class UserController {
  constructor(private readonly userService: UserService) {}

  @Get()
  getAllUsers(): any {
    return this.userService.getAllUsers();
  }

  @Get('/:username')
  getUser(@Param('username') username: string): any {
    return this.userService.getUser(username);
  }

  @Post('/users')
  createUser(
    @Body() body: { username: string; email: string; password: string },
  ): any {
    return this.userService.createUser(body);
  }

  @Patch('/users/:username')
  updateUser(
    @Param('username') username: string,
    @Body() body: { username: string; email: string; password: string },
  ): any {
    return this.userService.updateUser(username, body);
  }

  @Delete('/users/:username')
  deleteUser(@Param('username') username: string): any {
    return this.userService.deleteUser(username);
  }
}
