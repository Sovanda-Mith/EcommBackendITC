import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { User } from 'src/users/user.entity';
import { Repository } from 'typeorm';

@Injectable()
export class UserService {
  constructor(
    @InjectRepository(User)
    private usersRepo: Repository<User>,
  ) {}

  getAllUsers() {
    return this.usersRepo.find({ relations: ['tasks'] });
  }

  getUser(username: string): Promise<User | null> {
    return this.usersRepo.findOne({
      where: { username },
      relations: ['tasks'],
    });
  }

  createUser(userData: Partial<User>) {
    const user = this.usersRepo.create(userData);
    return this.usersRepo.save(user);
  }

  updateUser(username: string, userData: Partial<User>) {
    return this.usersRepo.update({ username }, userData);
  }

  deleteUser(username: string) {
    return this.usersRepo.delete({ username });
  }
}
